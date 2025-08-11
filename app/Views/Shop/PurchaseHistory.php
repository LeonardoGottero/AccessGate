<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    Historial de compras
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="parallax"></div>
    <div class="content">
    <h1 class="Hello-title">Historial de compras</h1>
    <?php if (empty($purchases)): ?>
        <p>No tienes compras registradas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Monto</th>
                    <th>ID de transacción PayPal</th>
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
<?= $this->endSection() ?>