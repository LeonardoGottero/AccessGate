<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\DeviceModel;
use App\Models\AccountModel;
use App\Models\LogModel;
use App\Models\DUModel;
use CodeIgniter\HTTP\RequestInterface;

class UserController extends BaseController{
    private $UserModel;
    private $AccountModel;
    private $LogModel;
    private $DUModel;
    private $DeviceModel;

    public function __construct(){
        $this->UserModel = new UserModel();
        $this->AccountModel = new AccountModel();
        $this->LogModel = new LogModel();
        $this->DUModel = new DUModel();
        $this->DeviceModel = new DeviceModel();
    }

    public function Index(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Users = $this->UserModel
            ->where('AccountId',$AccountId)
            ->orderBy('Name', 'ASC')
            ->findAll();
        return view('/Users/Users', ['Users' => $Users]);
    }

    public function CreateUser() {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        return view('/Users/User_Form');
    }

    public function SaveUser() {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Tag = $this->request->getPost('tag');
        $Email = $this->request->getPost('email');
        $Time = $this->request->getPost('time');
        if($Time){
            $FromTime = $this->request->getPost('from_time');
            $ToTime = $this->request->getPost('to_time');
        }elseif(!$Time){
            $FromTime = '00:00:00';
            $ToTime = '23:59:59';
        }
        $Token = bin2hex(random_bytes(16));
        $Data = [
            'name' => $this->request->getPost('name'),
            'surname' => $this->request->getPost('surname'),
            'email' => $Email,
            'tag' => $Tag,
            'token' => $Token,
            'from_time' => $FromTime,
            'to_time' => $ToTime,
            'AccountId' => $AccountId
        ];
        if ($this->UserModel->TagExists($Tag, null)) {
            return redirect()->back()->with('error', 'El Tag ya esta registrado en otro usuario');
        }
        $this->UserModel->save($Data);
        $this->SaveDU($Tag);
        $this->UserConfirmationEmail($Email, $Token);
        return redirect()->to('/Users');
    }

    public function SaveDU($Tag){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Devices = $this->DeviceModel->where('AccountId', $AccountId)->findAll();
        if($Devices){
            $User = $this->UserModel->where('tag',$Tag)->first();
            foreach($Devices as $Device){
                $DataDU[] = [
                    'DeviceId' => $Device['DeviceId'],
                    'UserId' => $User['UserId'],
                    'Allowed' => 0 
                ];
            }
            $this->DUModel->insertBatch($DataDU);
        }
    }

    public function EditUser($UserId) {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $User = $this->UserModel->find($UserId);
        return view('/Users/User_Form', ['User' => $User]);
    }

    public function UpdateUser($UserId) {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Time = $this->request->getPost('time');
        if($Time){
            $FromTime = $this->request->getPost('from_time');
            $ToTime = $this->request->getPost('to_time');
        }elseif(!$Time){
            $FromTime = '00:00:00';
            $ToTime = '23:59:59';
        }
        $Data = [
            'name' => $this->request->getPost('name'),
            'surname' => $this->request->getPost('surname'),
            'email' => $this->request->getPost('email'),
            'tag' => $this->request->getPost('tag'),
            'from_time' => $FromTime,
            'to_time' => $ToTime
        ];
        $User = $this->UserModel->where('UserId',$UserId)->first();
        $Tag = $this->request->getPost('tag');
        if ($this->UserModel->TagExists($Tag, $UserId)) {
            return redirect()->back()->with('error', 'El Tag ya esta registrado en otro usuario');
        }
        if ($this->UserModel->update($UserId, $Data)) {
            return redirect()->to('/Users')->with('message', 'Usuario actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el usuario');
        }
    }
    public function DeleteUser($UserId) {
        $User = $this->UserModel->find($UserId);
        if (!$User) {
            return redirect()->to('/Users')->with('error', 'Usuario no encontrado');
        }
        $this->UserModel->delete($UserId);
        $this->DUModel->where('UserId', $UserId)->delete();
        return redirect()->to('/Users')->with('message', 'Usuario eliminado correctamente');
    }
    public function SearchUser(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Search = trim($this->request->getPost('search'));
        
        $query = $this->UserModel->where('AccountId', $AccountId);
    
        if (!empty($Search)) {
            $Terms = explode(' ', $Search, 2);
            if (count($Terms) == 1) {
                $query->groupStart()
                    ->like('name', $Search, 'both')
                    ->orLike('surname', $Search, 'both')
                    ->groupEnd();
            } else {
                $query->groupStart()
                    ->like('name', $Terms[0], 'both')
                    ->like('surname', $Terms[1], 'both')
                    ->groupEnd();
            }
        }
    
        $Users = $query->orderBy('name', 'ASC')->findAll();
        return view('/Users/Users', ['Users' => $Users]);
    }
    public function UserInfo($UserId){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $User = $this->UserModel->find($UserId);
        $LastLog = $this->LogModel->GetLastLog($UserId);
        $dailyCounts = $this->LogModel->getDailyLogCountsForLast7Days($UserId);
        $labels = [];
        $entradasData = [];
        $salidasData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('D, M j', strtotime($date));
            $entradasData[$date] = 0;
            $salidasData[$date] = 0;
        }
        foreach ($dailyCounts as $row) {
            $date = $row['log_date'];
            if (isset($entradasData[$date])) {
                if ((int)$row['action'] === 1) {
                    $entradasData[$date] = (int)$row['count'];
                } elseif ((int)$row['action'] === 0) {
                    $salidasData[$date] = (int)$row['count'];
                }
            }
        }
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Entradas',
                    'data' => array_values($entradasData),
                    'borderColor' => 'rgb(75, 192, 192)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'fill' => false,
                    'tension' => 0.1
                ],
                [
                    'label' => 'Salidas',
                    'data' => array_values($salidasData),
                    'borderColor' => 'rgb(255, 99, 132)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'fill' => false,
                    'tension' => 0.1
                ]
            ]
        ];
        return view('/Users/UserInfo', [
            'User' => $User,
            'LastLog' => $LastLog,
            'chartData' => json_encode($chartData)
        ]);
    }
    protected function UserConfirmationEmail($Email, $Token){
        $User = $this->UserModel->where('email', $Email)->first();
        $Username = $User['name']." ".$User['surname'];
        $EmailService = \Config\Services::email();
        $EmailService->setFrom('accessgatenoreply@gmail.com', 'Accessgate');
        $EmailService->setTo($Email);
        $EmailService->setSubject('Confirmación de usuario');
        $EmailService->setMessage("Hola $Username, \n\nParece que tu mail esta intentando ser conectado a un usuario de accessgate. Si no perteneces a una organizacion que usa accessgate puedes eliminar tu usuario clickeando <a href='\n\nhttps://accessgate.onrender.com/Users/UserSelfDelete/$Token'>aquí</a>");
        $EmailService->send();
    }
    public function UserSelfDelete($Token){
        $User = $this->UserModel->where('token', $Token)->first();
        if (!$User) {
            return view('Users/SelfDeleteError');
        }
        $this->UserModel->delete($User['UserId']);
        $this->DUModel->where('UserId', $UserId)->delete();
        return view('Users/SelfDeleteSuccess');
    }
}