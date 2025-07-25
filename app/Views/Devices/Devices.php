<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispositivos</title>
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
    <script>
        const baseUrl = "<?= base_url() ?>";
    </script>
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
    <div class="parallax"></div>
        <div class="content">
            <center>
                <h1 class="Hello-title">Dispositivos</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Status</th>
                            <th>Uid</th>
                            <th>Modificar</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Devices as $Device) : ?>
                        <tr>
                            <td><a href="<?= site_url('Devices/Info/'.$Device['DeviceId']) ?>"><?= $Device['device_name'] ?></a></td>
                            <td>
                                <span class="device-status" data-Id="<?= esc($Device['DeviceId']) ?>">
                                    <?= esc($Device['Status'] ?? 'En espera') ?>
                                </span>
                            </td>
                            <td><?= $Device['device_uid'] ?></td>
                            <td><a href="<?= base_url('/Devices/Edit/'.$Device['DeviceId']); ?>"><button class="btn-icon-m"><img height="30px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                            <td><a href="<?= site_url('/Devices/Delete/'.$Device['DeviceId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?')"><button class="btn-icon-e"><img src="<?= base_url('Images/Delete.png')?>"></button></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="<?= base_url('/Devices/Create'); ?>"><button class="custom-button">Añadir Dispositivos</button></a>
            </center>
        </div>
    <div class="parallax"></div>
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
    <script src="<?= base_url('Scripts/StatusUpdater.js') ?>"></script> 
</body>
</html>