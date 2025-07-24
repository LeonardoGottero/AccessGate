<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $User['name']." ".$User['surname']; ?></title>
    <link rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
    <style>
         .parallax{
             background-image: url("<?= base_url('Images/parallax.jpg') ?>");
             max-height: 2000px; 
             background-attachment: fixed;
             background-position: center;
             background-repeat: no-repeat;
             background-size: cover;
             padding: 10%;
             padding-top: 20%;
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
                <a id="myBtn" style="cursor: pointer;">Cerrar sesion</a>>
            </div>
        </div>
    </nav>
    <div class="parallax">
    <div class="bienvenido">
            <center>
                <h1>Datos del Usuario</h1>
                <table class="accounttable">
                    <tr>
                        <th>Nombre del usuario</th>
                        <td><?= $User['name']." ".$User['surname'] ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $User['email'] ?></td>
                    </tr>
                    <tr>
                        <th>Tag</th>  
                        <td><?= $User['tag'] ?></td>
                    </tr>
                    <tr>
                        <th>Ultimo registro</th>  
                        <td><?php if(isset($LastLog)){ echo $LastLog['time']; }elseif(!isset($LastLog)){ echo "Hace más de 7 dias o nunca"; } ?></td>
                    </tr>
                </table>
                <h2 class="Hello-title">Horario habilitado</h2>
                <?php if($User['from_time'] == '00:00:00' & $User['to_time'] == '23:59:59'): ?>
                    <h2 class="Hello-title">Siempre</h2>
                <?php else: ?> 
                    <table class="accounttable">
                        <tr>
                            <th>Desde</th>  
                            <td><?= $User['from_time'] ?></td>
                        </tr>
                        <tr>
                            <th>Hasta</th>  
                            <td><?= $User['to_time'] ?></td>
                        </tr>
                    </table>
                <?php endif; ?>
                <p><?= session()->getFlashdata('message') ?><?= session()->getFlashdata('error') ?></p>
                <a href="<?= base_url('Users/Edit/'.$User['UserId']); ?>"><button class="custom-button">Editar Usuario</button></a>
                <a href="<?= site_url('Users/Delete/'.$User['UserId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?')"><button class="custom-button">Borrar Usuario</button></a>
            </center>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Cerrar Sesión</h1>
            <p>¿Estas seguro?</p>
            <a href="<?= site_url('Logout') ?>"><button class="custom-button">Cerrar</button></a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
</body>
</html>