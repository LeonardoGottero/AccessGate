<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
    <link id="form-theme-style" rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
</head>
<body>
    <center>
        <div class="card">
            <h1>¡Registro Confirmado!</h1>
            <p>Tu cuenta ha sido confirmada exitosamente. Ahora puedes iniciar sesión.</p>
            <a href="<?= site_url('Login') ?>">
                <button class="button" type="button">Iniciar sesión</button>
            </a>
        </div>
    </center>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>