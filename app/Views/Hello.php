<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
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
            <h1>Bienvenido de nuevo, <?= session()->get('accountname') ?></h1><br>
            <p>¿Que vas a hacer hoy?</p>
            <a href="<?= site_url('Users') ?>">
                <div class="banner" style="background-image: url('<?= base_url('Images/Users.jpg') ?>');">
                    <div class="banner-text">
                        <h2>Usuarios</h2>
                        <p>Revisa una lista de los miembros.</p>
                    </div>
                </div>
            </a>
            <a href="<?= site_url('Devices') ?>">
                <div class="banner" style="background-image: url('<?= base_url('Images/Devices.jpg') ?>');">
                    <div class="banner-text">
                        <h2>Dispositivos</h2>
                        <p>Visualiza tus dispositivos.</p>
                    </div>
                </div>
            </a>
            <a href="<?= site_url('Logs') ?>">
                <div class="banner" style="background-image: url('<?= base_url('Images/Logs.jpg') ?>');">
                    <div class="banner-text">
                        <h2>Registros</h2>
                        <p>Enterate de lo que paso los ultimos días.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>