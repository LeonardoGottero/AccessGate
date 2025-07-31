<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago exitoso</title>
    <link id="form-theme-style" rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
</head>
<body>
    <a href="<?= site_url('/Shop') ?>">
        <button class="back-button">
            <span>« Volver</span>
        </button>
    </a>
    <div class="card">
        <h1>¡Gracias por comprar <?= $Product['name'] ?>!</h1>
        <p>Precio pagado: $<?= $Product['price'] ?></p>
        <p>ID Transacción: <?= $Transaction->id ?></p>
        <a href="<?= site_url('/Shop') ?>"><button class="button">Seguir comprando</button></a><a href="<?= site_url('/') ?>"><button class="button">Volver a la página principal</button></a>
    </div>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>