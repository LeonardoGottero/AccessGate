<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    <?= isset($User) ? "Actualizar Usuario" : "Crear Usuario"; ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <?php
        if(isset($User)){
            if($User['from_time'] == "00:00:00" && $User['to_time'] == "23:59:59"){
                $Check = FALSE;
            }else{
                $Check = TRUE;
            }
        }
    ?>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <div class="card">
        <h1><?= isset($User) ? "Actualizar Usuario" : "Crear Usuario"; ?></h1>
        <form action="<?= isset($User) ? base_url('Users/Update/'.$User['UserId']) : base_url('Users/Save'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-control">
                <input class="input input-alt" type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?= isset($User) ? $User['name'] : '' ?>" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="text" class="input input-alt" id="surname" name="surname" placeholder="Apellido" value="<?= isset($User) ? $User['surname'] : '' ?>" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="email" class="input input-alt" id="email" name="email" placeholder="Email" value="<?= isset($User) ? $User['email'] : '' ?>" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="text" class="input input-alt" id="tag" name="tag" placeholder="Tag" value="<?= isset($User) ? $User['tag'] : '' ?>" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <p>Limitar horario</p>
            <label class="switch">
                <input type="checkbox" id="time" name="time" onclick="toggletime()" <?= isset($User) && $Check ? 'checked' : '' ?>>
                <span class="slider"></span>
            </label>
            <div id="times">
                <div class="form-control">
                    <input type="time" class="input input-alt" id="from_time" name="from_time" placeholder="Desde" disabled value="<?= isset($User) ? $User['from_time'] : '' ?>">
                    <span class="input-border input-border-alt"></span>
                </div>
                <div class="form-control">
                    <input type="time" class="input input-alt" id="to_time" name="to_time" placeholder="Hasta" disabled value="<?= isset($User) ? $User['to_time'] : '' ?>">
                    <span class="input-border input-border-alt"></span>
                </div>
                <div class="form-group">
                    <h2 class="Hello-title">Días permitidos</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Día</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $allowed_days = isset($User) && $User['allowed_days'] ? explode(',', $User['allowed_days']) : [];
                            foreach ($days as $i => $day) {
                                $checked = in_array($i, $allowed_days) ? 'checked' : '';
                                echo "<tr>
                                        <td>{$day}</td>
                                        <td>
                                            <label class='checkbox-container'>
                                                <input class='custom-checkbox' type='checkbox' name='allowed_days[]' value='{$i}' {$checked}>
                                                <span class='checkmark'></span>
                                            </label>
                                        </td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p><?= session()->getFlashdata('error') ?></p>
            <button type="submit" class="button"><?= isset($User) ? 'Actualizar Usuario' : 'Crear Usuario' ?></button>
        </form>
    </div>
<?= $this->endSection() ?>