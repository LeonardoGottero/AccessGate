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
        $Search = $this->request->getPost('search');
        $Terms = explode(' ', $Search);
        $this->UserModel->where('AccountId', $AccountId);
        if (count($Terms) == 1) {
            $Users = $this->UserModel
                ->groupStart()
                    ->like('name', $Search, 'both')
                    ->orLike('surname', $Search, 'both')
                ->groupEnd();
        }
        elseif (count($Terms) == 2) {
            $Users = $this->UserModel
                ->groupStart()
                    ->like('name', $Terms[0], 'both')
                    ->like('surname', $Terms[1], 'both')
                ->groupEnd();
        }else {
            $Users = $this->UserModel
                ->groupStart()
                    ->like('name', $Terms[0], 'both')
                    ->like('surname', $Terms[1], 'both')
                ->groupEnd();
        }
        $Users = $this->UserModel
            ->orderBy('name', 'ASC')
            ->findAll();
        return view('/Users/Users', ['Users' => $Users]);
    }
    public function UserInfo($UserId){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $User = $this->UserModel->find($UserId);
        $LastLog = $this->LogModel->GetLastLog($UserId);
        return view('/Users/UserInfo', ['User' => $User, 'LastLog' => $LastLog]);
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