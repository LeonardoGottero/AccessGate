<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>
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
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('/') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <ul class="nav-links">
            <?php if (session()->get('logged_in')) : ?>
                <li><a href="<?= site_url('Shop/History') ?>"><button class="custom-button">Historial de compras</button></a></li>
            <?php else: ?>
                <li><a href="<?= site_url('Login') ?>"><button class="custom-button">Iniciar Sesión</button></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <h1 class="Hello-title">¡Compra nuestros productos!</h1>
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
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
</body>
</html>