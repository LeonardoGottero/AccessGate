<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/BlackPage.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
    <?= $this->renderSection('styles') ?>
    <script src="https://cdn.botpress.cloud/webchat/v3.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/08/26/15/20250826150506-1UOHCQY4.js" defer></script>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('/') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <ul class="nav-links">
            <?php if (session()->get('logged_in')) : ?>
                <div class="dropdown">
                    <button class="dropbtn"><img height="30px" src="<?= base_url('Images/Menu.png')?>"></button>
                    <div class="dropdown-content">
                        <a href="<?= site_url('Hello') ?>">Inicio</a>
                        <a href="<?= site_url('Account') ?>">Cuenta</a>
                        <a href="<?= site_url('Devices') ?>">Dispositivos</a>
                        <a href="<?= site_url('Users') ?>">Usuarios</a>
                        <a href="<?= site_url('Logs') ?>">Registros</a>
                        <a href="<?= site_url('Shop') ?>">Tienda</a>
                        <a id="change-theme-btn" style="cursor: pointer;">Cambiar estilo</button>
                        <a id="myBtn" style="cursor: pointer;">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <li><a href="<?= site_url('Login') ?>"><button class="custom-button">Iniciar sesión</button></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Cerrar sesión</h1>
            <p>¿Estás seguro?</p>
            <a href="<?= site_url('Logout') ?>"><button class="custom-button">Cerrar</button></a>
        </div>
    </div>
    <?= $this->renderSection('content') ?>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contáctanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>