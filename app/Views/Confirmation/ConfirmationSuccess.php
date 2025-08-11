<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Confirmación de registro
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="card">
        <h1>¡Registro confirmado!</h1>
        <p>Tu cuenta ha sido confirmada exitosamente. Ahora puedes iniciar sesión.</p>
        <a href="<?= site_url('Login') ?>">
            <button class="button" type="button">Iniciar sesión</button>
        </a>
    </div>
<?= $this->endSection() ?>