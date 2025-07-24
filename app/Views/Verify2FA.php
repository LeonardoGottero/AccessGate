<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar 2FA</title>
    <link rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Login_logo.png') ?>">
</head>
<body>
    <div class="card">
        <h1>Verificación de inicio de sesión</h1>
        <p>Por favor, ingrese el código de 6 digitos de 2FA de su aplicación de autenticación.</p>
        <p><?= session()->getFlashdata('error') ?></p>
        <form method="post" action="<?= site_url('Process2FA') ?>">
            <div class="form-control">
                <input class="input input-alt" type="text" name="totp_code" placeholder="Código TOTP" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <button class="button" type="submit">Verificar</button>
        </form>
    </div>
</body>
</html>