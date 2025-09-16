<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/BlackPage.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
    <script src="https://cdn.botpress.cloud/webchat/v3.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/08/26/15/20250826150506-1UOHCQY4.js" defer></script>
</head>
<body>
    <div class="preloader">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('/') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <ul class="nav-links">
            <li><a href="<?= site_url('Shop') ?>"><button class="custom-button">Tienda</button></a></li>
            <li><a href="<?= site_url('Login') ?>"><button class="custom-button">Iniciar sesión</button></a></li>
        </ul>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <h1 class="Hello-title">¡Bienvenido a la página de Accessgate!</h1>
        <div class="card">
            <p class="card-title">
                Nos complace ofrecerte una solución eficiente y segura para controlar el acceso a tu empresa.
            </p>
            <a href="<?= site_url('Login') ?>">
                <div class="go-corner">
                    <div class="go-arrow">→</div>
                </div>
            </a>
        </div>
        <div class="card">
            <p class="card-title">
                Con nuestro sistema automatizado basado en tecnología RFID, podrás gestionar el acceso de manera ágil, garantizando la seguridad de tus instalaciones y el seguimiento detallado de entradas y salidas.
            </p>
            <a href="<?= site_url('Login') ?>">
                <div class="go-corner">
                    <div class="go-arrow">→</div>
                </div>
            </a>
        </div>
        <div class="card">
            <p class="card-title">
            A través de nuestra plataforma, tendrás acceso a todos los registros en tiempo real, optimizando la gestión de tu equipo y proporcionando una experiencia sin complicaciones.
            </p>
            <a href="<?= site_url('Login') ?>">
                <div class="go-corner">
                    <div class="go-arrow">→</div>
                </div>
            </a>
        </div>
        <h2 class="Hello-title">¡Gracias por confiar en nosotros para llevar la seguridad de tu empresa al siguiente nivel!</h2>
        <h2 class="Hello-title">Si no posees uno de nuestros dispositivos, compra uno aquí</h2>
        <a href="<?= site_url('Shop') ?>"><button class="custom-button">Tienda</button></a>
    </div>
    <div class="parallax"></div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contáctanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
    <script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.querySelector('.preloader').style.opacity = '0';
            setTimeout(function() {
                document.querySelector('.preloader').style.display = 'none';
            }, 500);
        }, 1000);
    });
    </script>
</body>
</html>