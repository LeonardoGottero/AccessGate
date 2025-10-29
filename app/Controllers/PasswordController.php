<?php
namespace App\Controllers;
use App\Models\AccountModel;
class PasswordController extends BaseController{
    private $AccountModel;
    public function __construct(){
        $this->AccountModel = new AccountModel();
    }
    public function ShowRecoveryForm(){
        return view('Password/MailToReset');
    }
    public function RequestRecovery(){
        $Email = $this->request->getPost('email');
        $Account = $this->AccountModel->where('email', $Email)->first();
        if ($Account) {
            $Token = bin2hex(random_bytes(50));
            $ExpiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->AccountModel->update($Account['AccountId'], [
                'reset_token' => $Token,
                'reset_token_expires' => $ExpiresAt
            ]);
            $EmailService = \Config\Services::email();
            $EmailService->setTo($Account['email']);
            $EmailService->setSubject('Recuperación de contraseña');
            $EmailService->setMessage("Haz clic <a href='\n\nhttps://accessgate.site/Password/ShowResetForm/$Token'>aquí</a> para recuperar tu contraseña");
            if ($EmailService->send()) {
                return redirect()->to('/Login')->with('message', 'Enlace de recuperación enviado a tu correo.');
            } else {
                return redirect()->back()->with('error', 'Hubo un problema al enviar el correo.');
            }
        } else {
            return redirect()->back()->with('error', 'El correo no está registrado.');
        }
    }
    public function ShowResetForm($Token){
        return view('Password/ResetPassword', ['token' => $Token]);
    }
    public function Update($Token){
        $Account = $this->AccountModel->where('reset_token', $Token)->first();
        if ($Account) {
            if (strtotime($Account['reset_token_expires']) < time()) {
                return redirect()->to('/Login')->with('error', 'El enlace de restablecimiento ha expirado.');
            }
            $Password = $this->request->getPost('password');
            $ConfirmPassword = $this->request->getPost('confirm_password');
            if ($Password === $ConfirmPassword) {
                $this->AccountModel->update($Account['AccountId'], [
                    'password' => $Password,
                    'reset_token' => null,
                    'reset_token_expires' => null
                ]);
                return redirect()->to('/Login')->with('message', 'Contraseña actualizada correctamente.');
            } else {
                return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
            }
        } else {
            return redirect()->to('/Login')->with('error', 'El enlace de restablecimiento no es válido.');
        }
    }
}
