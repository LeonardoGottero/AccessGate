<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Error en el pago
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <a href="<?= site_url('/Shop') ?>">
        <button class="back-button">
            <span>« Volver</span>
        </button>
    </a>
    <div class="card">
        <h1 style="color: #dc3545;">¡Error en el proceso de pago!</h1>
        <p>Por favor intenta nuevamente o contactá con soporte.</p>
        <?php if (session()->has('error')): ?>
            <div class="error-details">
                <p>Detalles técnicos: <?= session('error') ?></p>
            </div>
        <?php endif; ?>
        <a href="<?= base_url('/Shop') ?>">
            <button class="button">
                Volver a intentar
            </button>
        </a>
    </div>
<?= $this->endSection() ?>