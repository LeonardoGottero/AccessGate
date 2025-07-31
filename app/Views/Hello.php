<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
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
                <a id="myBtn" style="cursor: pointer;">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Cerrar Sesión</h1>
            <p>¿Estas seguro?</p>
            <a href="<?= site_url('Logout') ?>"><button class="custom-button">Cerrar</button></a>
        </div>
    </div>
    <div class="helloparallax">
        <div class="bienvenido">
            <h1>Bienvenido, <?= session()->get('accountname') ?></h1>
            <p>¿Que vas a hacer hoy?</p>
            <div class="banner" style="background-image: url('<?= base_url('Images/Users.jpg') ?>');">
                <p>Visualiza una lista de los usuarios.</p>
                <a href="<?= site_url('Users') ?>"><button class="custom-button">Usuarios</button></a>
            </div>
            <div class="banner" style="background-image: url('<?= base_url('Images/Devices.jpg') ?>');">
                <p>Visualiza tus dispositivos.</p>
                <a href="<?= site_url('Devices') ?>"><button class="custom-button">Dispositivos</button></a>
            </div>
            <div class="banner" style="background-image: url('<?= base_url('Images/Logs.jpg') ?>');">
                <p>Visualiza los registros.</p>
                <a href="<?= site_url('Logs') ?>"><button class="custom-button">Registros</button></a>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>