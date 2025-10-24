<?php
namespace App\Controllers;
use App\Models\DeviceModel;
use App\Models\UserModel;
use App\Models\DUModel;
use CodeIgniter\HTTP\RequestInterface;
class DeviceController extends BaseController{
    private $DeviceModel;
    private $UserModel;
    private $DUModel;
    public function __construct(){
        $this->DeviceModel = new DeviceModel();
        $this->UserModel = new UserModel();
        $this->DUModel = new DUModel();
    }
    public function Index(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Devices = $this->DeviceModel->where('AccountId',$AccountId)->orderBy('device_name', 'ASC')->findAll();
        return view('/Devices/Devices', ['Devices' => $Devices]);
    }
    public function CreateDevice() {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        return view('/Devices/DevicesForm');
    }
    public function SaveDevice() {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $DeviceName = $this->request->getPost('device_name');
        $DeviceUid = $this->request->getPost('device_uid');
        $Device = $this->DeviceModel->where('device_uid',$DeviceUid)->first();
        if (!$Device){
            return redirect()->back()->with('error', 'El dispositivo no existe');
        }
        $DeviceId = $Device['DeviceId'];
        $Data = [
            'device_name' => $DeviceName,
            'device_uid' => $DeviceUid,
            'AccountId' => $AccountId
        ];
        if ($this->DeviceModel->DeviceExists($DeviceUid, null, null)) {
            return redirect()->back()->with('error', 'El dispositivos ya esta registrado en otra cuenta');
        }
        $this->DeviceModel->update($DeviceId, $Data);
        $this->SaveDU($DeviceUid);
        return redirect()->to('/Devices');
    }
    public function SaveDU($DeviceUid){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Users = $this->UserModel->where('AccountId', $AccountId)->findAll();
        $Device = $this->DeviceModel->where('device_uid',$DeviceUid)->first();
        if($Users){
            foreach($Users as $User){
                $DataDU[] = [
                    'DeviceId' => $Device['DeviceId'],
                    'UserId' => $User['UserId'],
                    'Allowed' => 0 
                ];
            }
            $this->DUModel->insertBatch($DataDU);
        }
    }
    public function EditDevice($DeviceId) {
        $Device = $this->DeviceModel->find($DeviceId);
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Users = $this->UserModel->where('AccountId',$AccountId)->orderBy('name', 'ASC')->findAll();
        $DUs = $this->DUModel->where('DeviceId', $DeviceId)->findAll();
        return view('/Devices/DevicesForm', ['Device' => $Device, 'Users' => $Users, 'DUs' => $DUs]);
    }
    public function UpdateDevice($DeviceId) {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $DeviceName = $this->request->getPost('device_name');
        $DeviceUid = $this->request->getPost('device_uid');
        $Device = $this->DeviceModel->where('device_uid',$DeviceUid)->first();
        if (!$Device){
            return redirect()->back()->with('error', 'El dispositivo no existe');
        }
        $Users = $this->UserModel->where('AccountId', $AccountId)->findAll();
        $AllowedUsers = $this->request->getPost('allowed') ?? [];
        $AllIds = array_column($Users, 'UserId');
        $ForbiddenUsers = array_diff($AllIds, $AllowedUsers);
        $Data = [
            'device_name' => $DeviceName,
            'device_uid' => $DeviceUid
        ];
        if (!empty($AllowedUsers)) {
            $this->DUModel->whereIn('UserId', $AllowedUsers)
                    ->where('DeviceId', $DeviceId)
                    ->set(['allowed' => 1])
                    ->update();
        }
        if (!empty($ForbiddenUsers)) {
            $this->DUModel->whereIn('UserId', $ForbiddenUsers)
                    ->where('DeviceId', $DeviceId)
                    ->set(['allowed' => 0])
                    ->update();
        }
        if ($this->DeviceModel->DeviceExists($DeviceUid, $DeviceId, $AccountId)) {
            return redirect()->back()->with('error', 'El dispositivo ya esta registrado en otra cuenta');
        }
        if ($this->DeviceModel->update($DeviceId, $Data)) {
            return redirect()->to('/Devices')->with('message', 'Dispositivo actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el dispositivo');
        }
    }
    public function DeleteDevice($DeviceId) {
        $Device = $this->DeviceModel->find($DeviceId);
        if (!$Device) {
            return redirect()->to('/Devices')->with('error', 'Dispositivo no encontrado');
        }
        $this->DeviceModel->delete($DeviceId);
        $this->DUModel->where('DeviceId', $DeviceId)->delete();
        return redirect()->to('/Devices')->with('message', 'Dispositivo eliminado correctamente');
    }
    public function DeviceInfo($DeviceId){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Device = $this->DeviceModel->find($DeviceId);
        return view('/Devices/DeviceInfo', ['Device' => $Device]);
    }
}