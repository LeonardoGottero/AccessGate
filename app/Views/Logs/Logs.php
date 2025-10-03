<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    Registros
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="parallax"></div>
    <div class="content">
        <h1 class="Hello-title">Registros</h1>
        <p class="Hello-title">Los registros se eliminan cada 7 días</p>
        <form action="<?= site_url('/Logs/Search')?>" method="Post">
            <div class="search-container">
                <input type="text" name="search" placeholder="Buscar...">
                <button type="submit">
                    <img src="https://img.icons8.com/material-outlined/24/000000/search.png" alt="Buscar">
                </button>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Entrada o salida</th>
                    <th>Tiempo</th>
                    <th>Dispositivo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Logs as $Log) : ?>
                <tr>
                    <td><?= $Log['name']." ".$Log['surname'] ?></td>
                    <td>
                        <?php 
                            if($Log['action']==0){
                                echo "Salida";
                            }elseif($Log['action']==1){
                                echo "Entrada";
                            }
                        ?>
                    </td>
                    <td><?= $Log['time'] ?></td>
                    <td><?= $Log['device_name'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="parallax"></div>
<?= $this->endSection() ?>