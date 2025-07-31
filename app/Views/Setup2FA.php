<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial="width=device-width, initial-scale=1.0">
    <title>Configurar 2FA</title>
    <link id="form-theme-style" rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Login_logo.png') ?>">
</head>
<body>
    <div class="card">
        <h1>Configurar 2FA</h1>
        <h2>Paso 1: Escanea el Código QR</h2>
        <p>Escanea el siguiente código QR con tu aplicación de autenticación (ej. Google Authenticator).</p>
        <?php if (isset($qrUrl)): ?>
            <img src="<?= $qrUrl ?>" alt="Código QR para 2FA" style="width:200px; height:200px;">
        <?php else: ?>
            <p>No se pudo generar el código QR.</p>
        <?php endif; ?>
        <h2>Paso 2: Verifica la configuración</h2>
        <p>Una vez escaneado, ingresa el código generado por tu aplicación para confirmar.</p>
        <form method="post" action="<?= site_url('Process2FA') ?>">
            <div class="form-control">
                <input class="input input-alt" type="text" name="totp_code" placeholder="Código TOTP" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <button class="button" type="submit">Confirmar y Activar 2FA</button>
        </form>
        <p style="margin-top: 20px;">Puedes cambiar el 2FA en la configuración de tu perfil en cualquier momento.</p>
    </div>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>