<?php
namespace App\Controllers;
use App\Models\ShopModel;
use App\Models\PurchaseModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
class ShopController extends BaseController{
    private $ShopModel;
    private $PurchaseModel;
    private $ProvinceModel;
    private $CityModel;
    public function __construct(){
        $this->ShopModel = new ShopModel();
        $this->PurchaseModel = new PurchaseModel();
        $this->ProvinceModel = new ProvinceModel();
        $this->CityModel = new CityModel();
    }
    public function Index(){
        $Products = $this->ShopModel->findAll();
        return view('/Shop/Shop', ['Products' => $Products]);
    }
    public function History(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Purchases = $this->PurchaseModel->getPurchasesByAccountId($AccountId);
        $data['purchases'] = $Purchases;
        $data['title'] = 'Historial de Compras';
        return view('Shop/PurchaseHistory', $data);
    }
    public function Product($ProductId){
        $Product = $this->ShopModel->find($ProductId);
        if (!$Product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('/Shop/Product', ['Product' => $Product]);
    }
    public function Buy($ProductId){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Product = $this->ShopModel->find($ProductId);
        if (!$Product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $provinces = $this->ProvinceModel->findAll();
        return view('/Shop/Buy', [
            'Product' => $Product,
            'provinces' => $provinces
        ]);
    }
    public function getCitiesByProvince($provinceId){
        try {
            $cities = $this->CityModel->where('ProvinceId', $provinceId)->findAll();
            return $this->response->setJSON($cities);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error al obtener ciudades: ' . $e->getMessage()]);
        }
    }
}
