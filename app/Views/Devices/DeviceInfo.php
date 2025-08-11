<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    <?= $Device['device_name']; ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="helloparallax">
        <div class="bienvenido">
            <h1>Datos del dispositivo</h1>
            <table class="accounttable">
                <tr>
                    <th>Nombre del dispositivo</th>
                    <td><?= $Device['device_name'] ?></td>
                </tr>
                <tr>
                    <th>Uid</th>
                    <td><?= $Device['device_uid'] ?></td>
                </tr>
            </table>
            <p><?= session()->getFlashdata('message') ?><?= session()->getFlashdata('error') ?></p>
            <a href="<?= base_url('Devices/Edit/'.$Device['DeviceId']); ?>"><button class="custom-button">Editar dispositivo</button></a>
            <a href="<?= site_url('Devices/Delete/'.$Device['DeviceId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este dispositivo?')"><button class="custom-button">Borrar dispositivo</button></a>
        </div>
    </div>
<?= $this->endSection() ?>