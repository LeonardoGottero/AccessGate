<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Error en la eliminación de usuario
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="card">
        <h1>Error en la eliminación de usuario</h1>
        <p>El usuario no existe en la base de datos de Accessgate.(Probablemente ya ha sido eliminado)</p>
    </div>
<?= $this->endSection() ?>