<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Login
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <button class="back-button" onClick="history.back();">
         <span>« Volver</span>
    </button>
    <div class="card">
        <h1>Bienvenido</h1>
        <h2>Por favor, inicie sesión</h2>
        <p><?= session()->getFlashdata('error') ?><?= session()->getFlashdata('message') ?></p>
        <form method="post" action="<?= site_url('LoginAccount') ?>">
            <div class="form-control">
                <input class="input input-alt" type="username" name="accountname" placeholder="Nombre de cuenta">
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control"><input class="input input-alt" type="password" name="password" placeholder="Contraseña"><span class="input-border input-border-alt"></span></div>
            <button class="button" type="submit">Entrar</button>
        </form>
        <p>¿Olvidaste tu contraseña?</p>
        <a href="<?= base_url('/Password/ShowRecoveryForm') ?>">
            <button class="button">Recuperar Contraseña</button>
        </a>
        <p>¿No tienes una cuenta?</p>
        <a href="<?= site_url('/Register') ?>">
            <button class="button">Registrarse</button>
        </a>
    </div>
<?= $this->endSection() ?>