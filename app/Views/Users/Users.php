<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('Hello') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <div class="dropdown">
            <button class="dropbtn"><img height="30px" src="<?= base_url('Images/Menu.png')?>"></button>
            <div class="dropdown-content">
                <a href="<?= site_url('Hello') ?>">Inicio</a>
                <a href="<?= site_url('Account') ?>">Cuenta</a>
                <a href="<?= site_url('Devices') ?>">Dispositivos</a>
                <a href="<?= site_url('Users') ?>">Usuarios</a>
                <a href="<?= site_url('Logs') ?>">Registros</a>
                <a href="<?= site_url('Shop') ?>">Tienda</a>
                <a id="change-theme-btn" style="cursor: pointer;">Cambiar Estilo</button>
                <a id="myBtn" style="cursor: pointer;">Cerrar sesion</a>
            </div>
        </div>
    </nav>
    <div class="parallax"></div>
    <div class="content">
        <center>
            <h1 class="Hello-title">Usuarios</h1>
            <form action="<?= site_url('/Users/Search')?>" method="Post">
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
            <a href="<?= base_url('/Users/Create'); ?>"><button class="custom-button">Añadir Usuario</button></a>
        </center>
    </div>
    <div class="parallax"></div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Cerrar Sesión</h1>
            <p>¿Estas seguro?</p>
            <a href="<?= site_url('Logout') ?>"><button class="custom-button">Cerrar</button></a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>