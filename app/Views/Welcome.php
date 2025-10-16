<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accessgate</title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/Welcome.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
    <script src="https://cdn.botpress.cloud/webchat/v3.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/08/26/15/20250826150506-1UOHCQY4.js" defer></script>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="<?= site_url('/') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <a href="javascript:void(0);" class="nav-toggle" id="nav-toggle">
            &#9776; </a>
        <div class="nav-links" id="nav-links">
            <a href="<?= site_url('/') ?>">Inicio</a>
            <a href="<?= site_url('/Shop') ?>">Tienda</a>
            <a href="<?= site_url('/Login') ?>">Iniciar sesión</a>
        </div>
    </div>
    <div class="navbarblank">
    </div>
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <img src="<?= base_url('Images/Carrousel_1.png')?>">
                <div class="carousel-caption">
                    <h1>Somos Accessgate</h1>
                    <h2>Nos complace ofrecerte una solución eficiente y segura para controlar el acceso a tu empresa.</h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('Images/Carrousel_2.png')?>">
                <div class="carousel-caption">
                    <h1>Acceso con tarjeta</h1>
                    <h2>Con nuestro sistema automatizado basado en tecnología RFID, podrás gestionar el acceso de manera ágil, garantizando la seguridad de tus instalaciones y el seguimiento detallado de entradas y salidas.</h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('Images/Carrousel_3.png')?>">
                <div class="carousel-caption">
                    <h1>Software de gestión</h1>
                    <h2>A través de nuestra plataforma, tendrás acceso a todos los registros en tiempo real, optimizando la gestión de tu equipo y proporcionando una experiencia sin complicaciones.</h2>
                </div>
            </div>
        </div>
        <a class="prev">&#10094;</a>
        <a class="next">&#10095;</a>
    </div>
    <div class="shop-section">
        <h1>¿Interesado en nuestros productos?</h1>
        <h2>Visita nuestra tienda virtual.</h2>
        <a href="<?= site_url('/Shop') ?>" class="shop-button">Ir a la tienda</a>
    </div>
    <div class="parallax"></div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const carouselInner = document.querySelector(".carousel-inner");
            const items = document.querySelectorAll(".carousel-item");
            const prevButton = document.querySelector(".prev");
            const nextButton = document.querySelector(".next");

            let currentIndex = 0;
            const totalItems = items.length;

            function updateCarousel() {
                carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
            }

            nextButton.addEventListener("click", function() {
                currentIndex = (currentIndex + 1) % totalItems;
                updateCarousel();
            });

            prevButton.addEventListener("click", function() {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
                updateCarousel();
            });
        });
        document.getElementById('nav-toggle').addEventListener('click', function() {
            document.getElementById('nav-links').classList.toggle('show');
        });
    </script>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contáctanos</a></p>
    </footer>
</body>
</html>