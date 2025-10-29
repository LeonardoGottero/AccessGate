<?php
namespace App\Controllers;
use App\Models\AccountModel;
use CodeIgniter\HTTP\RequestInterface;
class AccountController extends BaseController {
    private $AccountModel;
    public function __construct(){
        $this->AccountModel = new AccountModel();
    }
    public function Index() {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Account = $this->AccountModel->where('AccountId', $AccountId)->first();
        return view('/Account/Account');
    }
    public function ChangeSomethingForm($field) {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        if ($field && $field == "Nombre"){
            $AccountName = session()->get('accountname');
            return view('/Account/ChangeSomething', ['field' => $field, 'name' => $AccountName]);
        }elseif ($field && $field == "Mail") {
            $AccountMail = session()->get('email');
            return view('/Account/ChangeSomething', ['field' => $field, 'email' => $AccountMail]);
        }else{
            return view('/Account/Account');
        }
    }
    public function UpdateAccountname() {
        $AccountId = session()->get('accountid');
        $AccountNewName = $this->request->getPost('newvalue');
        $Account = $this->AccountModel->where('AccountId', $AccountId)->first();
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        if (!$AccountNewName) {
            return redirect()->back()->withInput()->with('error', 'Nombre no valido');
        }
        if ($this->AccountModel->AccountnameExists($AccountNewName)) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está registrado');
        }
        if (!password_verify($this->request->getPost('currentpassword'), $Account['password'])) {
            return redirect()->back()->withInput()->with('error', 'La contraseña actual es incorrecta');
        }
        $this->AccountModel->update($Account['AccountId'], ['accountname' => $AccountNewName]);
        session()->set('accountname', $AccountNewName);
        return redirect()->to('/Account')->with('message', 'El nombre ha sido cambiada correctamente');
    }
    public function UpdateAccountemail() {
        $AccountId = session()->get('accountid');
        $AccountNewEmail = $this->request->getPost('newvalue');
        $Account = $this->AccountModel->where('AccountId', $AccountId)->first();
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        if (!$AccountNewEmail) {
            return redirect()->back()->withInput()->with('error', 'Email no valido');
        }
        if ($this->AccountModel->EmailExists($AccountNewEmail)) {
            return redirect()->back()->with('error', 'El correo electrónico ya está registrado');
        }
        if (!password_verify($this->request->getPost('currentpassword'), $Account['password'])) {
            return redirect()->back()->withInput()->with('error', 'La contraseña actual es incorrecta');
        }
        $this->AccountModel->update($Account['AccountId'], ['email' => $AccountNewEmail]);
        session()->set('email', $AccountNewEmail);
        return redirect()->to('/Account')->with('message', 'El email ha sido cambiada correctamente');
    }
    public function ChangePasswordForm() {
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        return view('/Account/ChangePassword');
    }
    public function ChangePassword() {
        $rules = [
            'current_password' => 'required',
            'new_password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'min_length' => 'La nueva contraseña debe tener al menos 8 caracteres.',
                ]
            ],
            'confirm_password' => 'required|matches[new_password]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Account = $this->AccountModel->where('AccountId', $AccountId)->first();
        if (!password_verify($this->request->getPost('current_password'), $Account['password'])) {
            return redirect()->back()->withInput()->with('error', 'La contraseña actual es incorrecta');
        }
        $new_password = $this->request->getPost('new_password');
        if (password_verify($new_password, $Account['password'])) {
            return redirect()->back()->withInput()->with('error', 'La nueva contraseña no puede ser la misma que la contraseña actual');
        }
        $this->AccountModel->update($Account['AccountId'], ['password' => $new_password]);
        return redirect()->to('/Account')->with('message', 'La contraseña ha sido cambiada correctamente');
    }
    public function SendDeleteMail(){
        $AccountId = session()->get('accountid');
        if (!$AccountId) {
            return redirect()->to('/Login');
        }
        $Account = $this->AccountModel->where('accountid', $AccountId)->first();
        $Email = $Account['email'];
        $Token = bin2hex(random_bytes(16));
        $this->AccountModel->update($Account['AccountId'],['token' => $Token]);
        $this->DeleteConfirmationEmail($Email, $AccountId, $Token);
        return redirect()->back()->with('message', 'Se le ha enviado un mail de confirmación');
    }
    protected function DeleteConfirmationEmail($Email, $AccountId, $Token){
        $Account = $this->AccountModel->where('accountid', $AccountId)->first();
        $AccountName = $Account['accountname'];
        $EmailService = \Config\Services::email();
        $EmailService->setFrom('accessgatenoreply@gmail.com', 'Accessgate');
        $EmailService->setTo($Email);
        $EmailService->setSubject('Confirmación de eliminacion de cuenta');
        $EmailService->setMessage("Hola $AccountName, \n\nParece que quieres eliminar tu cuenta de accessgate. Puedes eliminarla haciendo click <a href='\n\nhttps://accessgate.site/Account/GoToDelete/$Token'>aquí</a>");
        if (!$EmailService->send()) {
            log_message('message', 'No se pudo enviar el correo de confirmación: ' . $EmailService->printDebugger());
        }
    }
    public function GoToDelete($Token){
        return view('Account/Deleteaccount', ['token' => $Token]);
    }
    public function DeleteAccount($Token){
        $Password = $this->request->getPost('password');
        $Account = $this->AccountModel->where('token', $Token)->first();
        if(password_verify($Password,$Account['password'])){
            $this->AccountModel->where('AccountId', $Account['AccountId'])->delete();
            session()->destroy();
            return redirect()->to('/');
        }else{
            return redirect()->to('/Account/GoToDelete/'.$Token)->with('error','Contraseña Incorrecta');
        }
    }
}