<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Commands\CleanupAccounts;
use App\Models\AccountModel;
use Config\Services;
class AdminController extends BaseController{
    private $AccountModel;
    public function __construct(){
        $this->AccountModel = new AccountModel();
    }
    public function AdminDashboard(){
        $AccountId = session()->get('accountid');
        $Account = $this->AccountModel->where('AccountId', $AccountId)->first();
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        if (!$Account['rol'] == 'Admin' ) {
            return redirect()->to('/Login')->with('message', 'No tienes acceso a esta pagina');
        }
        return view('/Admin/AdminDashboard');
    }
    public function RunAccountCleanupManually(){
        $AccountId = session()->get('accountid');
        $Account = $this->AccountModel->where('AccountId', $AccountId)->first();
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        if (!$Account['rol'] == 'Admin' ) {
            return redirect()->to('/Login')->with('message', 'No tienes acceso a esta pagina');
        }
        $logger = Services::logger();
        $commands = Services::commands();
        $cleanupCommand = new CleanupAccounts($logger, $commands);
        $cleanupCommand->run([]);
        return redirect()->back()->with('message', 'Se ha intentado ejecutar la limpieza de cuentas expiradas manualmente.');
    }
    public function RunAccountCleanupAuto(){
        $logger = Services::logger();
        $commands = Services::commands();
        $cleanupCommand = new CleanupAccounts($logger, $commands);
        $cleanupCommand->run([]);
    }
    public function SearchAccount(){
        $request = \Config\Services::request();
        $term = $request->getGet('term');
        if ($term) {
            $Accounts = $this->AccountModel->like('accountname', $term)->findAll();
        } else {
            $Accounts = [];
        }
        return $this->response->setJSON($Accounts);
    }
    public function UpdateAccountRole(){
        $request = Services::request();
        $accountId = $request->getPost('accountId');
        $newRole = $request->getPost('newRole');
        $Account = $this->AccountModel->find($accountId);
        if ($Account) {
            $this->AccountModel->update($accountId, ['rol' => $newRole]);
            return $this->response->setJSON(['success' => true, 'message' => 'Rol de cuenta actualizado con éxito.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Cuenta no encontrada.']);
        }
    }
}