<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de compras</title>
    <link id="page-theme-style" rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('/') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
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
    <h1 class="Hello-title">Historial de Compras</h1>
    <?php if (empty($purchases)): ?>
        <p>No tienes compras registradas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Monto</th>
                    <th>ID de Transacción PayPal</th>
                    <th>Lugar de entrega</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?= date('Y-m-d H:i', strtotime($purchase['created_at'])) ?></td>
                        <td><?= $purchase['product_name'] ?? 'Producto Desconocido' ?></td>
                        <td><?= $purchase['amount'] . ' USD' ?></td>
                        <td><?= $purchase['paypal_transaction_id'] ?? 'N/A' ?></td>
                        <td><?= $purchase['address'].', '.$purchase['city']?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
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