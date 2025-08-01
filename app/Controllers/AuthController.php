<?php
namespace App\Controllers;
use App\Models\AccountModel;
use App\Libraries\TOTP;
require_once APPPATH . 'Libraries/TOTP.php';
class AuthController extends BaseController {
    private $AccountModel;
    public function __construct(){
        $this->AccountModel = new AccountModel();
    }
    public function Register() {
        return view('Register');
    }
    public function RegisterAccount(){
        $Email = $this->request->getPost('email');
        $Accountname = $this->request->getPost('accountname');
        $Password = $this->request->getPost('password');
        if ($this->AccountModel->EmailExists($Email)) {
            return redirect()->back()->with('error', 'El correo electrónico ya está registrado');
        }
        if ($this->AccountModel->AccountnameExists($Accountname)) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está registrado');
        }
        if (strlen($Password) < 8 || strlen($Password) > 20) {
            return redirect()->back()->with('error', 'La contraseña debe tener entre 8 y 20 caracteres');
        }
        $Token = bin2hex(random_bytes(16));
        $Data = [
            'accountname' => $Accountname,
            'email' => $Email,
            'password' => $Password,
            'token' => $Token,
            'token_created_at' => date('Y-m-d H:i:s'),
            'rol' => 'Cliente',
            'totp_secret' => null
        ];
        $this->AccountModel->save($Data);
        $this->SendConfirmationEmail($Email, $Accountname, $Token);
        return redirect()->to('/Login');
    }
    protected function SendConfirmationEmail($Email, $Accountname, $Token){
        $EmailService = \Config\Services::email();
        $EmailService->setFrom('accessgatenoreply@gmail.com', 'Accessgate');
        $EmailService->setTo($Email);
        $EmailService->setSubject('Confirmación de Registro');
        $EmailService->setMessage("Hola $Accountname, \n\nGracias por registrarte. Por favor, confirma tu correo haciendo clic <a href='\n\nhttps://accessgate.onrender.com/Confirm/$Token'>aquí</a>");
        if (!$EmailService->send()) {
            log_message('error', 'No se pudo enviar el correo de confirmación: ' . $EmailService->printDebugger());
        }
    }
    public function ConfirmEmail($Token){
        $Account = $this->AccountModel->where('token', $Token)->first();
        if ($Account) {
            $creationTime = strtotime($Account['token_created_at']);
            $currentTime = time();
            $timeDiff = $currentTime - $creationTime;
            $threeHoursInSeconds = 3 * 60 * 60; // 3 horas
            if ($timeDiff <= $threeHoursInSeconds) {
                $this->AccountModel->update($Account['AccountId'], ['is_active' => 1, 'token' => null, 'token_created_at' => null]);
                return view('Confirmation/ConfirmationSuccess');
            } else {
                $this->AccountModel->update($Account['AccountId'], ['token' => null, 'token_created_at' => null]);
                return view('Confirmation/ConfirmationError', ['message' => 'El token de activación ha expirado.']);
            }
        } else {
            return view('Confirmation/ConfirmationError', ['message' => 'Token de activación inválido.']);
        }
    }
    public function Login(){
        return view('Login');
    }
    public function LoginAccount(){
        $Accountname = $this->request->getPost('accountname');
        $Password = $this->request->getPost('password');
        $Account = $this->AccountModel->where('accountname', $Accountname)->first();
        if ($Account && password_verify($Password, $Account['password'])) {
            if($Account['is_active']==1){
                if (!empty($Account['totp_secret'])) {
                    session()->set([
                        'accountname_2fa' => $Account['accountname'],
                        'accountid_2fa' => $Account['AccountId'],
                        '2fa_pending' => true,
                    ]);
                    return redirect()->to('/verify-2fa');
                } else {
                    session()->set([
                        'accountname' => $Account['accountname'],
                        'email' => $Account['email'],
                        'accountid' => $Account['AccountId'],
                        'rol' => $Account['rol'],
                        'logged_in' => true,
                    ]);
                    return redirect()->to('/Hello');
                }
            }elseif($Account['is_active']==0){
                return redirect()->back()->with('error', 'Cuenta no activa, Verifique el correo para enlace de confirmación');
            }
        } else {
            return redirect()->back()->with('error', 'Nombre o contraseña no registrados');
        }
    }
    public function Verify2FA() {
        if (!session()->get('2fa_pending') && !session()->get('logged_in')) {
            return redirect()->to('/Login');
        }
        return view('Verify2FA');
    }
    public function Process2FA() {
        $totpCode = $this->request->getPost('totp_code');
        $currentLoggedInAccountId = session()->get('accountid');
        $pendingLoginAccountId = session()->get('accountid_2fa');
        $accountId = null;
        $isLoginFlow = false;
        if ($currentLoggedInAccountId) {
            $accountId = $currentLoggedInAccountId;
            $isLoginFlow = false; 
        } elseif ($pendingLoginAccountId) {
            $accountId = $pendingLoginAccountId;
            $isLoginFlow = true; 
        }
        if (!$accountId || !$totpCode) {
            return redirect()->to('/Login')->with('error', 'Error al procesar la verificación 2FA. No se encontraron los datos de la sesión o el código TOTP.');
        }
        $Account = $this->AccountModel->find($accountId);
        if ($Account && !empty($Account['totp_secret'])) {
            $totp = new TOTP($Account['totp_secret']);
            if ($totp->verifyCode($totpCode)) {
                if ($isLoginFlow) {
                    session()->set([
                        'accountname' => $Account['accountname'],
                        'email' => $Account['email'],
                        'accountid' => $Account['AccountId'],
                        'rol' => $Account['rol'],
                        'logged_in' => true,
                    ]);
                    session()->remove('accountname_2fa');
                    session()->remove('accountid_2fa');
                    session()->remove('2fa_pending');
                    return redirect()->to('/Hello')->with('message', 'Inicio de sesión con 2FA exitoso.');
                } else {
                    return redirect()->to('/Account')->with('message', 'Autenticación de dos factores configurada/cambiada exitosamente.');
                }
            } else {
                if ($isLoginFlow) {
                    return redirect()->back()->with('error', 'Código 2FA incorrecto.');
                } else {
                    return redirect()->to('/setup-2fa')->with('error', 'Código 2FA incorrecto. Asegúrate de haber escaneado el nuevo código QR y de que la hora de tu dispositivo esté sincronizada.');
                }
            }
        }
        return redirect()->to('/Login')->with('error', 'Error en la verificación 2FA. Contacta con soporte si el problema persiste.');
    }
    public function Welcome(){
        if (!session()->get('logged_in')) {
            return view('Welcome');
        }else{
            return view('Hello');
        }
    }
    public function Index(){
        if (!session()->get('logged_in')) {
            return redirect()->to('/Login');
        }
        return view('Hello');
    }
    public function Logout(){
        session()->destroy();
        return redirect()->to('/');
    }
    public function Account() {
        if (!session()->get('logged_in')) {
            return redirect()->to('/Login');
        }
        $accountId = session()->get('accountid');
        $Account = $this->AccountModel->find($accountId);
        $data = [
            'totp_secret' => $Account['totp_secret'] ?? null,
        ];
        return view('Account', $data);
    }
    public function ShowSetup2FA() {
        if (!session()->get('logged_in')) {
            return redirect()->to('/Login');
        }
        $accountId = session()->get('accountid');
        $Account = $this->AccountModel->find($accountId);
        $secret = \App\Libraries\generateSecret();
        $this->AccountModel->update($accountId, ['totp_secret' => $secret]);
        $qrUrl = \App\Libraries\getQrCodeUrl($secret, session()->get('email'), 'Accessgate', 6, 30); 
        if (!empty($Account['totp_secret'])) {
            session()->setFlashdata('message', 'Se ha generado un nuevo secreto para 2FA. Escanea el nuevo QR.');
        }
        return view('Setup2FA', ['qrUrl' => $qrUrl, 'secret' => $secret]);
    }
    public function Disable2FA() {
        if (!session()->get('logged_in')) {
            return redirect()->to('/Login');
        }
        $accountId = session()->get('accountid');
        $this->AccountModel->update($accountId, ['totp_secret' => null]);
        return redirect()->to('/Account')->with('message', 'Autenticación de dos factores desactivada.');
    }
}