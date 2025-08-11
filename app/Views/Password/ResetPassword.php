<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Cambiar Contraseña
<?= $this->endSection() ?>
<?= $this->section('content') ?>
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
<?= $this->endSection() ?>