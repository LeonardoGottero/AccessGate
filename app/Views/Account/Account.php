<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= session()->get('accountname') ?></title>
    <link rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
    <style>
         .parallax{
             background-image: url("<?= base_url('Images/parallax.png') ?>");
             max-height: 2000px;
             background-attachment: fixed;
             background-position: center;
             background-repeat: no-repeat;
             background-size: cover;
             padding: 10%;
             padding-top: 20%;-
             padding-bottom: 20%;
         }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('Hello') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <div class="dropdown">
            <button class="dropbtn"><img height="30px" src="<?= base_url('Images/Menu.png')?>"></button>
            <div class="dropdown-content">
                <a href="<?= site_url('Hello') ?>">Inicio</a>
                <a href="<?= site_url('Account') ?>">Cuenta</a>
                <a href="<?= site_url('Devices') ?>">Dispositivos</a>
                <a href="<?= site_url('Users') ?>">Usuarios</a>
                <a href="<?= site_url('Logs') ?>">Registros</a>
                <a href="<?= site_url('Shop') ?>">Tienda</a>
                <a id="myBtn" style="cursor: pointer;">Cerrar sesion</a>
            </div>
        </div>
    </nav>
    <div class="parallax">
        <div class="bienvenido">
            <center>
                <h1>Datos de la cuenta</h1>
                <table class="accounttable">
                    <tr>
                        <th>Nombre de cuenta</th>
                        <td><?= session()->get('accountname') ?></td>
                        <td width="40px"><a href="<?= base_url('Account/ChangeSomethingForm/Nombre'); ?>"><button class="btn-icon"><img height="20px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= session()->get('email') ?></td>
                        <td width="40px"><a href="<?= base_url('Account/ChangeSomethingForm/Mail'); ?>"><button class="btn-icon"><img height="20px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                    </tr>
                </table>
                <a href="<?= site_url('/Devices') ?>"><button class="custom-button">Ver dispositivos</button></a>
                <p><?= session()->getFlashdata('message') ?><?= session()->getFlashdata('error') ?></p>
                <?php if(session()->get('rol') == 'Admin'): ?>
                    <a href="<?= site_url('/Admin') ?>"><button class="custom-button">Vista admin</button></a>
                <?php endif; ?>
                <a href="<?= site_url('/Account/ChangePasswordForm') ?>"><button class="custom-button">Cambiar Contraseña</button></a>
                <a id="twoFaBtn" style="cursor: pointer;"><button class="custom-button">Activar o Cambiar 2FA</button></a>
                <a href="<?= site_url('/Account/DeleteAccount') ?>"><button class="custom-button">Borrar cuenta</button></a>
            </center>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1>Cerrar Sesión</h1>
                <p>¿Estas seguro?</p>
                <a href="<?= site_url('Logout') ?>"><button class="custom-button">Cerrar</button></a>
            </div>
        </div>
        <div id="twoFaModal" class="modal">
            <div class="modal-content">
                <span class="closeTwoFa">&times;</span>
                <h1>Configurar 2FA</h1>
                <p>¿Estás seguro que deseas Configurar la autenticación de dos factores?</p>
                <p>Este proceso eliminara el anterior 2FA.</p>
                <a href="<?= site_url('setup-2fa') ?>"><button class="custom-button">Continuar</button></a>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
</body>
</html>