<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Eliminar Cuenta
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="card">
        <h1>Eliminar Cuenta</h1>
        <p><?= session()->getFlashdata('error') ?></p>
        <form action="<?= base_url('/Account/DeleteAccount/'.$token) ?>" method="post">
            <div class="form-control">
                <input class="input input-alt" placeholder="Contraseña" type="password" name="password" id="password" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <button class="button" type="submit">Eliminar Cuenta</button>
        </form>
        <p>¿Te arrepentiste?</p>
        <a href="<?= site_url('/Account') ?>"><button class="button">Volver</button></a>
    </div>
<?= $this->endSection() ?>