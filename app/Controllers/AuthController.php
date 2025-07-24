<?php
namespace App\Controllers;

use App\Models\AccountModel;
use App\Libraries\TOTP; // Importa la clase TOTP

// Incluye el archivo que contiene las funciones globales generateSecret y getQrCodeUrl
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
            'totp_secret' => null // Inicializa el secreto TOTP como nulo al registrar
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
                // Verificar si el 2FA está habilitado para este usuario
                if (!empty($Account['totp_secret'])) {
                    // Si el 2FA está habilitado, redirigir a una página para solicitar el código TOTP
                    session()->set([
                        'accountname_2fa' => $Account['accountname'], // Guardar temporalmente el nombre de usuario
                        'accountid_2fa' => $Account['AccountId'], // Guardar temporalmente el ID de usuario
                        '2fa_pending' => true, // Indicar que el 2FA está pendiente
                    ]);
                    return redirect()->to('/verify-2fa');
                } else {
                    // Si el 2FA no está habilitado, iniciar sesión normalmente
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
            // If not pending 2FA login AND not already logged in (meaning, trying to access Verify2FA without proper context)
            return redirect()->to('/Login');
        }
        return view('Verify2FA'); // Vista para ingresar el código TOTP
    }

    public function Process2FA() {
        $totpCode = $this->request->getPost('totp_code');

        // Determinar el ID de la cuenta basado en el contexto:
        // 1. El usuario ya está logueado (configurando/cambiando 2FA).
        // 2. El usuario está en medio de un inicio de sesión (después de la contraseña, antes del código 2FA).
        $currentLoggedInAccountId = session()->get('accountid'); // Este estará seteado si el usuario ya está logueado
        $pendingLoginAccountId = session()->get('accountid_2fa'); // Este estará seteado si el usuario está iniciando sesión y el 2FA está pendiente

        $accountId = null;
        $isLoginFlow = false; // Bandera para diferenciar el flujo

        if ($currentLoggedInAccountId) {
            $accountId = $currentLoggedInAccountId;
            $isLoginFlow = false; // El usuario ya está logueado, es un flujo de configuración/cambio
        } elseif ($pendingLoginAccountId) {
            $accountId = $pendingLoginAccountId;
            $isLoginFlow = true; // El usuario está en el flujo de verificación 2FA de inicio de sesión
        }

        // Validación básica
        if (!$accountId || !$totpCode) {
            // Si no podemos determinar la cuenta o no se envió el código TOTP, algo está mal.
            // Redirigir a login como medida de seguridad.
            return redirect()->to('/Login')->with('error', 'Error al procesar la verificación 2FA. No se encontraron los datos de la sesión o el código TOTP.');
        }

        $Account = $this->AccountModel->find($accountId);

        // Asegurarse de que la cuenta existe y tiene un secreto configurado
        if ($Account && !empty($Account['totp_secret'])) {
            $totp = new TOTP($Account['totp_secret']);
            if ($totp->verifyCode($totpCode)) {
                // Código TOTP es válido.
                if ($isLoginFlow) {
                    // El usuario estaba iniciando sesión, así que ahora lo logueamos completamente.
                    session()->set([
                        'accountname' => $Account['accountname'],
                        'email' => $Account['email'],
                        'accountid' => $Account['AccountId'],
                        'rol' => $Account['rol'],
                        'logged_in' => true,
                    ]);
                    // Limpiar variables de sesión temporales del flujo de inicio de sesión.
                    session()->remove('accountname_2fa');
                    session()->remove('accountid_2fa');
                    session()->remove('2fa_pending');
                    return redirect()->to('/Hello')->with('message', 'Inicio de sesión con 2FA exitoso.');
                } else {
                    // El usuario ya estaba logueado (configurando o cambiando 2FA).
                    // Simplemente redirigirlo de vuelta a su página de cuenta con un mensaje de éxito.
                    return redirect()->to('/Account')->with('message', 'Autenticación de dos factores configurada/cambiada exitosamente.');
                }
            } else {
                // Código TOTP inválido.
                if ($isLoginFlow) {
                    // Si es el flujo de inicio de sesión, redirige de vuelta a la página de verificación.
                    return redirect()->back()->with('error', 'Código 2FA incorrecto.');
                } else {
                    // Si es el flujo de configuración/cambio, redirige de vuelta a la página de configuración (donde ven el QR)
                    // para que puedan intentar de nuevo con el nuevo secreto/QR.
                    return redirect()->to('/setup-2fa')->with('error', 'Código 2FA incorrecto. Asegúrate de haber escaneado el nuevo código QR y de que la hora de tu dispositivo esté sincronizada.');
                }
            }
        }

        // Fallback si los datos de la cuenta son inconsistentes (ej. cuenta no encontrada o el secreto desapareció inesperadamente).
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

    // Funciones para la configuración de 2FA
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