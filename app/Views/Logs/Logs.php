<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <link id="theme-style" rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
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
                <a id="change-theme-btn" style="cursor: pointer;">Cambiar Estilo</button>
                <a id="myBtn" style="cursor: pointer;">Cerrar sesion</a>
            </div>
        </div>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <center>
            <h1 class="Hello-title">Registros</h1>
            <p class="Hello-title">Los registros se eliminan cada 7 días</p>
            <form action="<?= site_url('/Logs/Search')?>" method="Post">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Buscar...">
                    <button type="submit">
                        <img src="https://img.icons8.com/material-outlined/24/000000/search.png" alt="Buscar">
                    </button>
                </div>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Entrada o salida</th>
                        <th>Tiempo</th>
                        <th>Dispositivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Logs as $Log) : ?>
                    <tr>
                        <td><?= $Log['name']." ".$Log['surname'] ?></td>
                        <td>
                            <?php 
                                if($Log['action']==0){
                                    echo "Salida";
                                }elseif($Log['action']==1){
                                    echo "Entrada";
                                }
                            ?>
                        </td>
                        <td><?= $Log['time'] ?></td>
                        <td>
                            <?php 
                                foreach ($Devices as $Device) {
                                    if ($Device['DeviceId'] == $Log['DeviceId']) {
                                        echo $Device['device_name'];
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>