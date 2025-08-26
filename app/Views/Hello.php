<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    Bienvenido
<?= $this->endSection() ?>
<?= $this->section('styles') ?>
    <script src="https://cdn.botpress.cloud/webchat/v3.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/08/26/13/20250826135914-FCJI7Y8T.js" defer></script>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="helloparallax">
        <div class="bienvenido">
            <h1>Bienvenido de nuevo, <?= session()->get('accountname') ?></h1><br>
            <p>¿Qué vas a hacer hoy?</p>
            <a href="<?= site_url('Users') ?>">
                <div class="banner" style="background-image: url('<?= base_url('Images/Users.jpg') ?>');">
                    <div class="banner-text">
                        <h2>Usuarios</h2>
                        <p>Revisa una lista de los miembros.</p>
                    </div>
                </div>
            </a>
            <a href="<?= site_url('Devices') ?>">
                <div class="banner" style="background-image: url('<?= base_url('Images/Devices.jpg') ?>');">
                    <div class="banner-text">
                        <h2>Dispositivos</h2>
                        <p>Visualiza tus dispositivos.</p>
                    </div>
                </div>
            </a>
            <a href="<?= site_url('Logs') ?>">
                <div class="banner" style="background-image: url('<?= base_url('Images/Logs.jpg') ?>');">
                    <div class="banner-text">
                        <h2>Registros</h2>
                        <p>Entérate de lo que pasó los últimos días.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
<?= $this->endSection() ?>
