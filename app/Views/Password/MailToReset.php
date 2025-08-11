<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Enviar correo
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
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
<?= $this->endSection() ?>