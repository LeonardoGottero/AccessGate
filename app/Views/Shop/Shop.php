<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>
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
                        <a id="change-theme-btn" style="cursor: pointer;">Cambiar estilo</button>
                        <a id="myBtn" style="cursor: pointer;">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <li><a href="<?= site_url('Login') ?>"><button class="custom-button">Iniciar sesión</button></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <h1 class="Hello-title">¡Comprá nuestros productos!</h1>
        <div class="shop-container">
            <?php foreach ($Products as $Product) : ?>
                <div class="product-div">
                    <a href="<?= site_url('/Shop/Product/'.$Product['ProductId']) ?>"><img src="<?= base_url('Images/'.$Product['image'])?>"></a>
                    <h2><?= $Product['name'] ?></h2>
                    <h2>USD $<?= $Product['price'] ?></h2>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="parallax"></div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Cerrar sesión</h1>
            <p>¿Estás seguro?</p>
            <a href="<?= site_url('Logout') ?>"><button class="custom-button">Cerrar</button></a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contáctanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>