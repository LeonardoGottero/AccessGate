<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use Config\Paypal;
use App\Models\ShopModel; 
use App\Models\PurchaseModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
class PaypalController extends BaseController{
    protected $paypalConfig;
    private $ShopModel;
    private $PurchaseModel;
    private $ProvinceModel;
    private $CityModel;
    public function __construct(){
        $this->paypalConfig = new PayPal();
        $this->ShopModel = new ShopModel();
        $this->PurchaseModel = new PurchaseModel();
        $this->ProvinceModel = new ProvinceModel();
        $this->CityModel = new CityModel();
    }
    public function CreatePayment($ProductId){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $provinceId = $this->request->getPost('province');
        $cityId = $this->request->getPost('city');
        $provinceName = '';
        if ($provinceId) {
            $province = $this->ProvinceModel->find($provinceId);
            if ($province) {
                $provinceName = $province['province'];
            }
        }
        $cityName = '';
        if ($cityId) {
            $city = $this->CityModel->find($cityId);
            if ($city) {
                $cityName = $city['city'];
            }
        }
        $purchaseDetails = [
            'completename' => $this->request->getPost('completename'),
            'address' => $this->request->getPost('address'),
            'phone' => $this->request->getPost('phone'),
            'province' => $provinceName,
            'city' => $cityName
        ];
        session()->set('purchase_details', $purchaseDetails);
        $Product = $this->ShopModel->find($ProductId);
        if (!$Product) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }
        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $Product['price']
                ],
            ]],
            'application_context' => [
                'return_url' => base_url('Paypal/Success/'. $ProductId),
                'cancel_url' => base_url('Paypal/Cancel')
            ]
        ];
        $response = $this->makePayPalRequest(
            '/v2/checkout/orders',
            'POST',
            json_encode($data)
        );
        if ($response && $response->statusCode === 201) {
            $approvalUrl = null;
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    $approvalUrl = $link->href;
                    break;
                }
            }
            if ($approvalUrl) {
                return redirect()->to($approvalUrl);
            }
        }
        log_message('error', 'PayPal Create Payment Error: ' . json_encode($response));
        return redirect()->back()->with('error', 'Error al crear el pago.');
    }
    public function Success($ProductId){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $token = $this->request->getGet('token');
        if (!$token) {
             return redirect()->to('/Paypal/Error')->with('error', 'Token de pago no encontrado.');
        }
        $Product = $this->ShopModel->find($ProductId);
        if (!$Product) {
             return redirect()->to('/Paypal/Error')->with('error', 'Producto no encontrado.');
        }
        $response = $this->MakePayPalRequest(
            "/v2/checkout/orders/$token/capture",
            'POST'
        );
        if ($response && $response->statusCode === 201 && isset($response->result->status) && $response->result->status === 'COMPLETED') {
            $purchaseDetails = session()->get('purchase_details');
            session()->remove('purchase_details');
            $completeName = $purchaseDetails['completename'] ?? '';
            $address = $purchaseDetails['address'] ?? '';
            $phone = $purchaseDetails['phone'] ?? '';
            $cityName = $purchaseDetails['city'] ?? '';
            $provinceName = $purchaseDetails['province'] ?? '';
            $purchaseData = [
                'AccountId' => $AccountId,
                'ProductId' => $ProductId,
                'paypal_order_id' => $response->result->id,
                'paypal_transaction_id' => $response->result->purchase_units[0]->payments->captures[0]->id ?? null,
                'amount' => $Product['price'],
                'status' => $response->result->status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'complete_name' => $completeName,
                'address' => $address,
                'phone' => $phone,
                'province' => $provinceName,
                'city' => $cityName
            ];
            $PurchaseModel = new \App\Models\PurchaseModel();
            $PurchaseModel->save($purchaseData);
            return view('Shop/PaymentSuccess', ['Product' => $Product, 'Transaction' => $response->result, 'Name' => $completeName, 'address' => $address, 'phone' => $phone]);
        }
        $errorMessage = 'Error desconocido al procesar el pago.';
        if ($response && isset($response->result->message)) {
            $errorMessage = $response->result->message;
        } elseif ($response && isset($response->result->details[0]->description)) {
            $errorMessage = $response->result->details[0]->description;
        } else {
            log_message('error', 'PayPal Capture Error Response: ' . json_encode($response));
        }
        return redirect()->to('/Paypal/Error')->with('error', $errorMessage);
    }
    public function Cancel(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        return view('/Shop/PaymentCancel');
    }
    public function PaymentError(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $errorMessage = session()->getFlashdata('error') ?? 'Hubo un error con el pago.';
        return view('/Shop/PaymentError', ['error' => $errorMessage]);
    }
    private function MakePayPalRequest($endpoint, $method, $data = null){
        $ch = curl_init();
        $url = ($this->paypalConfig->environment === 'sandbox')
            ? "https://api.sandbox.paypal.com$endpoint"
            : "https://api.paypal.com$endpoint";

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode(
                    $this->paypalConfig->clientId . ':' . $this->paypalConfig->secret
                )
            ],
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
        ]);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($curlError) {
             log_message('error', "cURL Error: " . $curlError);
             return null; 
        }

        return (object)[
            'statusCode' => $statusCode,
            'result' => json_decode($response)
        ];
    }
}