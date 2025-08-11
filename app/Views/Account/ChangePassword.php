<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link id="form-theme-style" rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
</head>
<body>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <div class="card">
        <h1>Cambiar Contraseña</h1>
        <p>Recuerde que su contraseña:</p>
        <p>-Debe tener mas de 8 caracteres y menos de 20</p>
        <p>-No debe ser igual que la anterior</p>
        <form action="<?= site_url('/Account/ChangePassword') ?>" method="post">
        <?= csrf_field() ?>
            <div class="form-control">
                <input class="input input-alt" type="password" name="current_password" placeholder="Contraseña actual">
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input class="input input-alt" type="password" name="new_password" placeholder="Nueva contraseña">
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input class="input input-alt" type="password" name="confirm_password" placeholder="Confirmar nueva contraseña">
                <span class="input-border input-border-alt"></span>
            </div>
            <button class="button" type="submit">Cambiar Contraseña</button>
            <?php if (session()->get('error')): ?>
                <div>
                    <?= session()->get('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->get('errors')): ?>
                <div>
                    <?php foreach (session()->get('errors') as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
<?= $this->endSection() ?>