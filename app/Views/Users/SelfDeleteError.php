<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Error en la eliminacion de usuario
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="card">
        <h1>Error en la eliminacion de usuario</h1>
        <p>El usuario no existe en la Base de datos de accessgate.(Probablemente ya haya sido eliminado)</p>
    </div>
<?= $this->endSection() ?>