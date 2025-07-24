<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar correo</title>
    <link rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
</head>
<body>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <center>
        <div class="card">
            <h1>Enviar correo</h1>
            <h2>Para recuperar contraseña</h2>
            <form action="<?= base_url('/Password/RequestRecovery') ?>" method="post">
                <div class="form-control">
                    <input class="input input-alt" placeholder="Email" type="email" name="email" id="email" required>
                    <span class="input-border input-border-alt"></span>
                </div>
                <button class="button" type="submit">Enviar Correo</button>
            </form>
        </div>
    </center>
</body>
</html>