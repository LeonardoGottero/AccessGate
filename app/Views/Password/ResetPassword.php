<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
</head>
<body>
    <center>
        <div class="card">
            <h1>Recuperar Contraseña</h1>
            <form action="<?= base_url('/Password/Update/'.$token) ?>" method="post">
                <div class="form-control">
                    <input class="input input-alt" placeholder="Nueva Contraseña" type="password" name="password" id="password" required>
                    <span class="input-border input-border-alt"></span>
                </div>
                <div class="form-control">
                    <input class="input input-alt" placeholder="Confirmar Contraseña" type="password" name="confirm_password" id="confirm_password" required>
                    <span class="input-border input-border-alt"></span>
                </div>
                <button class="button" type="submit">Restablecer Contraseña</button>
            </form>
        </div>
    </center>
</body>
</html>