<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $Product['name']; ?></title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/BlackPage.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
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
                        <a href="<?= site_url('Shop/History') ?>">Historial de compras</a>
                        <a id="change-theme-btn" style="cursor: pointer;">Cambiar Estilo</button>
                        <a id="myBtn" style="cursor: pointer;">Cerrar sesion</a>
                    </div>
                </div>
            <?php else: ?>
                <li><a href="<?= site_url('Login') ?>"><button class="custom-button">Iniciar Sesión</button></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <h1 class="Hello-title"><?= $Product['name']; ?></h1>
        <div class="content-body">
            <img src="<?= base_url('Images/'.$Product['image'])?>" class="product-img">
            <div class="text-container">
                <p><?= $Product['description'] ?></p>
                <h3>USD $<?= $Product['price'] ?></h3>
                <a href="<?= site_url('/Shop/Buy/'.$Product['ProductId']) ?>"><button class="custom-button">Comprar</button></a>
            </div>
        </div>
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