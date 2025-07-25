<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
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
             padding-top: 100px;
             padding-bottom: 20%;
         }
    </style>
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
            <li><a href="<?= site_url('Login') ?>"><button class="custom-button">Iniciar Sesión</button></a></li>
        </ul>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <center>
            <h1 class="Hello-title">¡Bienvenido a la página de accessgate!</h1>
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
        </center>
    </div>
    <div class="parallax"></div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
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