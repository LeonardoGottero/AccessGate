<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispositivos</title>
    <link id="theme-style" rel="stylesheet" href="<?= base_url('CSS/Page.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
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
    <script>
        const baseUrl = "<?= base_url() ?>";
    </script>
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
                <h1 class="Hello-title">Dispositivos</h1>
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
                            <td><a href="<?= site_url('/Devices/Delete/'.$Device['DeviceId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?')"><button class="btn-icon-e"><img src="<?= base_url('Images/Delete.png')?>"></button></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="<?= base_url('/Devices/Create'); ?>"><button class="custom-button">Añadir Dispositivos</button></a>
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
    <script src="<?= base_url('Scripts/Pag.js') ?>"></script>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
</body>
</html>