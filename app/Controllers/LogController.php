<?php
namespace App\Controllers;
use App\Models\LogModel;
use App\Models\UserModel;
use App\Models\AccountModel;
use App\Models\DeviceModel;
use CodeIgniter\HTTP\RequestInterface;
class LogController extends BaseController{
    private $LogModel;
    private $UserModel;
    private $AccountModel;
    private $DeviceModel;
    public function __construct(){
        $this->LogModel = new LogModel();
        $this->UserModel = new UserModel();
        $this->AccountModel = new AccountModel();
        $this->DeviceModel = new DeviceModel();
    }
    public function Index(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Logs = $this->LogModel->GetLogsWithAccountId($AccountId);
        return view('/Logs/Logs', ['Logs' => $Logs]);
    }
    public function SearchUserLogs(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Search = $this->request->getPost('search');
        $Logs = $this->LogModel->GetLogsWithNames($AccountId, $Search);
        $Devices = $this->DeviceModel->where('AccountId', $AccountId)->findAll();
        return view('/Logs/Logs', ['Logs' => $Logs, 'Devices' => $Devices]);
    }
    public function DeleteLogsAuto(){
        $this->LogModel->DeleteOldLogs();
    }
}