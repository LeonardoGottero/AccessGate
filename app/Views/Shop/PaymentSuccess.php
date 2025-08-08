<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Pago exitoso
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <a href="<?= site_url('/Shop') ?>">
        <button class="back-button">
            <span>« Volver</span>
        </button>
    </a>
    <div class="card">
        <h1>¡Gracias por comprar <?= $Product['name'] ?>!</h1>
        <p>Precio pagado: $<?= $Product['price'] ?></p>
        <p>ID Transacción: <?= $Transaction->id ?></p>
        <a href="<?= site_url('/Shop') ?>"><button class="button">Seguir comprando</button></a><a href="<?= site_url('/') ?>"><button class="button">Volver a la página principal</button></a>
    </div>
<?= $this->endSection() ?>