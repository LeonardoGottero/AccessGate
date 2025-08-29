<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    Dispositivos
<?= $this->endSection() ?>
<?= $this->section('styles') ?>
    <style>
        .status-dot {
            height: 12px;
            width: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
        }
        .status-dot-green { background-color: #28a745; }
        .status-dot-yellow { background-color: #ffc107; }
        .status-dot-red { background-color: #dc3545; }
        .status-dot-blue { background-color: #007bff; }
        .status-dot-grey { background-color: #6c757d; }
    </style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="parallax"></div>
        <div class="content">
            <h1 class="Hello-title">Dispositivos</h1>
            <div class="adddiv">
                <a href="<?= base_url('/Devices/Create'); ?>"><button class="custom-button">Añadir</button></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Uid</th>
                        <th>Modificar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function getStatusClass($status) {
                        switch ($status) {
                            case 'Abriendo': return 'status-dot-green';
                            case 'Abierto': return 'status-dot-yellow';
                            case 'Cerrando': return 'status-dot-red';
                            case 'En espera': return 'status-dot-blue';
                            default: return 'status-dot-grey';
                        }
                    }

                    foreach ($Devices as $Device) :
                        $status = $Device['status'] ?? 'No recibido';
                        $statusClass = getStatusClass($status);
                    ?>
                    <tr>
                        <td><a href="<?= site_url('Devices/Info/'.$Device['DeviceId']) ?>"><?= $Device['device_name'] ?></a></td>
                        <td>
                            <span class="status-dot <?= $statusClass ?>"></span>
                            <span class="device-status" data-id="<?= esc($Device['DeviceId']) ?>">
                                <?= esc($status) ?>
                            </span>
                        </td>
                        <td><?= $Device['device_uid'] ?></td>
                        <td><a href="<?= base_url('/Devices/Edit/'.$Device['DeviceId']); ?>"><button class="btn-icon-m"><img height="30px" src="<?= base_url('Images/Edit.png')?>"></button></a></td>
                        <td><a href="<?= site_url('/Devices/Delete/'.$Device['DeviceId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este dispositivo?')"><button class="btn-icon-e"><img src="<?= base_url('Images/Delete.png')?>"></button></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <div class="parallax"></div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script>
        const baseUrl = "<?= base_url() ?>";
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusElements = document.querySelectorAll('.device-status');
            if (statusElements.length === 0) {
                return;
            }
            function updateAllStatuses() {
                statusElements.forEach(span => {
                    const deviceId = span.dataset.id;
                    if (!deviceId) {
                        return;
                    }
                    fetch(`${baseUrl}/Device/GetStatus?Device=${deviceId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status && span.textContent.trim() !== data.status) {
                                span.textContent = data.status;
                                const dot = span.previousElementSibling;
                                if (!dot || !dot.classList.contains('status-dot')) {
                                    return;
                                }
                                dot.className = 'status-dot';
                                let newClass;
                                switch (data.status) {
                                    case 'Abriendo':
                                        newClass = 'status-dot-green';
                                        break;
                                    case 'Abierto':
                                        newClass = 'status-dot-yellow';
                                        break;
                                    case 'Cerrando':
                                        newClass = 'status-dot-red';
                                        break;
                                    case 'En espera':
                                        newClass = 'status-dot-blue';
                                        break;
                                    default:
                                        newClass = 'status-dot-grey';
                                        break;
                                }
                                dot.classList.add(newClass);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching status for ' + deviceId + ':', error);
                            span.textContent = 'Desconocido';
                            const dot = span.previousElementSibling;
                             if (dot && dot.classList.contains('status-dot')) {
                                dot.className = 'status-dot status-dot-grey';
                             }
                        });
                });
            }
            setInterval(updateAllStatuses, 500);
        });
    </script>
<?= $this->endSection() ?>