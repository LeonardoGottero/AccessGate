<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de compras</title>
    <link rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
    <style>
        .parallax{
            background-image: url("<?= base_url('Images/parallax.jpg') ?>");
            max-height: 2000px; 
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 10%;
            padding-top: 20%;
            padding-bottom: 20%;
        }
     </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= site_url('/') ?>"><img src="<?= base_url('Images/Logo2.png')?>"></a>
        </div>
        <ul class="nav-links">
            <li><a href="<?= site_url('Shop') ?>"><button class="custom-button">Volver a la tienda</button></a></li>
        </ul>
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
    <footer class="footer">
        <p>&copy; 2025 Accessgate. Todos los derechos reservados. <a href="mailto:accessgatenoreply@gmail.com">Contactanos</a></p>
    </footer>
</body>
</html>