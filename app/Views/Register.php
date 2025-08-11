<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Registrarse
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <div class="card">
        <form method="post" action="<?= site_url('RegisterAccount') ?>">
            <h1>Registrarse</h1>
            <h2>Crear una cuenta</h2>
            <div class="form-control"><input class="input input-alt" type="username" name="accountname" placeholder="Nombre de cuenta" required><span class="input-border input-border-alt"></span></div>
            <div class="form-control"><input class="input input-alt" type="email" name="email" placeholder="Email" required><span class="input-border input-border-alt"></span></div>
            <div class="form-control"><input class="input input-alt" type="password" name="password" placeholder="Contraseña" required><span class="input-border input-border-alt"></span></div>
            <p>La contraseña debe tener entre 8 y 20 caracteres</p>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <p><?= session()->getFlashdata('error') ?></p>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <p><?= session()->getFlashdata('success') ?></p>
                </div>
            <?php endif; ?>
            <button class="button" type="submit">Registrarse</button>
        </form>
        <p>¿Tienes una cuenta?</p>
        <a href="<?= site_url('Login') ?>">
            <button class="button" type="button">Iniciar sesión</button>
        </a>
    </div>
<?= $this->endSection() ?>