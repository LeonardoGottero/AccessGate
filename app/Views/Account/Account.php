<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    <?= session()->get('accountname') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="parallax">
        <div class="bienvenido">
            <h1>Datos de la cuenta</h1>
            <table class="accounttable">
                <tr>
                    <th>Nombre de cuenta</th>
                    <td><?= session()->get('accountname') ?></td>
                    <td width="40px"><a href="<?= base_url('Account/ChangeSomethingForm/Nombre'); ?>"><button class="btn-icon"><img height="20px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= session()->get('email') ?></td>
                    <td width="40px"><a href="<?= base_url('Account/ChangeSomethingForm/Mail'); ?>"><button class="btn-icon"><img height="20px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                </tr>
            </table>
            <p><?= session()->getFlashdata('message') ?><?= session()->getFlashdata('error') ?></p>
            <?php if(session()->get('rol') == 'Admin'): ?>
                <a href="<?= site_url('/Admin') ?>"><button class="custom-button">Vista admin</button></a>
            <?php endif; ?>
            <a href="<?= site_url('/Account/ChangePasswordForm') ?>"><button class="custom-button">Cambiar Contraseña</button></a>
            <a id="twoFaBtn" style="cursor: pointer;"><button class="custom-button">Activar o Cambiar 2FA</button></a>
            <a href="<?= site_url('/Account/DeleteAccount') ?>"><button class="custom-button">Borrar cuenta</button></a>
        </div>
        <div id="twoFaModal" class="modal">
            <div class="modal-content">
                <span class="closeTwoFa">&times;</span>
                <h1>Configurar 2FA</h1>
                <p>¿Estás seguro que deseas configurar la autenticación de dos factores?</p>
                <p>Este proceso eliminará el anterior 2FA.</p>
                <a href="<?= site_url('setup-2fa') ?>"><button class="custom-button">Continuar</button></a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>