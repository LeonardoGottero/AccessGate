<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Verificar 2FA
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="card">
        <h1>Verificación de inicio de sesión</h1>
        <p>Por favor, ingrese el código de 6 dígitos de 2FA de su aplicación de autenticación.</p>
        <p><?= session()->getFlashdata('error') ?></p>
        <form method="post" action="<?= site_url('Process2FA') ?>">
            <div class="form-control">
                <input class="input input-alt" type="text" name="totp_code" placeholder="Código TOTP" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <button class="button" type="submit">Verificar</button>
        </form>
    </div>
<?= $this->endSection() ?>