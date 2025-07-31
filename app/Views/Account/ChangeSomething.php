<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar <?= esc($field) ?></title>
    <link id="form-theme-style" rel="stylesheet" href="<?= base_url('CSS/Form.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
</head>
<body>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <div class="card">
        <h1>Cambiar <?= esc($field) ?></h1>
        <p>Utiliza el formulario a continuación para actualizar tu <?= esc(strtolower($field)) ?>.</p>
        <?php
        if ($field == 'Nombre' && isset($name)):
        ?>
            <p>Valor actual de Nombre: <strong><?= esc($name) ?></strong></p>
        <?php elseif ($field == 'Mail' && isset($email)): ?>
            <p>Valor actual de Mail: <strong><?= esc($email) ?></strong></p>
        <?php endif; ?>
        <form action="<?= base_url('/Account/UpdateField/'.$field) ?>" method="post">
            <input type="hidden" name="field" value="<?= esc($field) ?>">
            <div class="form-control">
                <input type="<?php if ($field == 'Mail'): echo 'email'; else: echo 'text'; endif; ?>"
                    id="newvalue"
                    name="newvalue"
                    class="input input-alt"
                    required
                    placeholder="Ingresa el nuevo <?= strtolower(esc($field)) ?>">
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="password"
                    id="currentpassword"
                    name="currentpassword"
                    class="input input-alt"
                    required
                    placeholder="Ingresa tu contraseña actual">
                <span class="input-border input-border-alt"></span>
            </div>
            <button class="button" type="submit">Guardar Cambios</button>
            <?php if (session()->get('error')): ?>
                <div class="error">
                    <?= session()->get('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->get('errors')): ?>
                <div class="error">
                    <?php foreach (session()->get('errors') as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </form>
        <p><a href="<?= base_url('/Account') ?>" class="link">Cancelar y volver a la cuenta</a></p> </body>
    </div>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</html>