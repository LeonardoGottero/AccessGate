<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    <?= isset($Device) ? "Actualizar dispositivo" : "Crear dispositivo"; ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <div class="card">
        <h1><?= isset($Device) ? "Actualizar dispositivo" : "Crear dispositivo"; ?></h1>
        <form action="<?= isset($Device) ? base_url('Devices/Update/'.$Device['DeviceId']) : base_url('Devices/Save'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-control">
                <input type="text" class="input input-alt" id="device_name" name="device_name" placeholder="Nombre del dispositivo" value="<?= isset($Device) ? $Device['device_name'] : '' ?>" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="text" class="input input-alt" id="device_uid" name="device_uid" placeholder="UID del dispositivo" value="<?= isset($Device) ? $Device['device_uid'] : '' ?>" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <p><?= session()->getFlashdata('error') ?></p>
            <button type="submit" class="button"><?= isset($Device) ? 'Actualizar dispositivo' : 'Crear dispositivo' ?></button>
            <?php if(isset($Users)): ?>
                <h2 class="Hello-title">Usuarios habilitados   <button type="button" class="btn-icon-m" onclick="toggleSection()" ><span class="arrow">▶</span></button></h2>
                <div id="mySection" class="section">
                    <center>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>
                                        <label class="checkbox-container">
                                            <input class="custom-checkbox" type="checkbox" id="checkAll">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Users as $User) : ?>
                                    <tr>
                                        <td><?= $User['name']." ".$User['surname'] ?></td>
                                        <td>
                                            <label class="checkbox-container">
                                                <input class="custom-checkbox" type="checkbox" name="allowed[]" value="<?= $User['UserId'] ?>"
                                                <?php 
                                                    foreach ($DUs as $DU) {
                                                        if ($DU['UserId'] == $User['UserId'] && $DU['Allowed'] == 1) {
                                                            echo 'checked';
                                                            break;
                                                        }
                                                    }
                                                ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </center>
                </div>
            </form>
        <?php else: ?>
            <p>Para garantizar a los usuarios acceso al dispositivo deberás modificarlo después de crearlo.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>