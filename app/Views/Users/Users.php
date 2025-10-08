<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    Usuarios
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="parallax"></div>
    <div class="content">
        <h1 class="Hello-title">Usuarios</h1>
        <div class="adddiv">
            <form action="<?= site_url('/Users/Search')?>" method="Post">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Buscar...">
                    <button type="submit">
                        <img src="https://img.icons8.com/material-outlined/24/000000/search.png" alt="Buscar">
                    </button>
                </div>
            </form>
            <a href="<?= base_url('/Users/Create'); ?>"><button class="custom-button">Añadir</button></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Tag</th>
                    <th>Modificar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Users as $User) : ?>
                <tr>
                    <td><a href="<?= site_url('Users/Info/'.$User['UserId']) ?>"><?= $User['name'] ?> <?= $User['surname'] ?></a></td>
                    <td><?= $User['tag'] ?></td>
                    <td><a href="<?= base_url('Users/Edit/'.$User['UserId']); ?>"><button class="btn-icon-m"><img height="30px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                    <td><a href="<?= site_url('Users/Delete/'.$User['UserId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?')"><button class="btn-icon-e"><img src="<?= base_url('Images/Delete.png')?>"></button></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="parallax"></div>
<?= $this->endSection() ?>