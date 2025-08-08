<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Pago cancelado
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <a href="<?= site_url('/Shop') ?>">
        <button class="back-button">
            <span>« Volver</span>
        </button>
    </a>
    <div class="card">
        <h1>Se canceló el pago</h1>
        <a href="<?= site_url('/Shop') ?>"><button class="button">Volver a la tienda</button></a>
    </div>
<?= $this->endSection() ?>