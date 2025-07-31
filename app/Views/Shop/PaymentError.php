<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en el pago</title>
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
        <h1 style="color: #dc3545;">¡Error en el proceso de pago!</h1>
        <p>Por favor intenta nuevamente o contacta con soporte.</p>
        <?php if (session()->has('error')): ?>
            <div class="error-details">
                <p>Detalles técnicos: <?= session('error') ?></p>
            </div>
        <?php endif; ?>
        <a href="<?= base_url('/Shop') ?>">
            <button class="button">
                Volver a intentar
            </button>
        </a>
    </div>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>