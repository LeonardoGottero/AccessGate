<?= $this->extend('Layouts/Page') ?>
<?= $this->section('title') ?>
    <?= $User['name']." ".$User['surname']; ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <div class="helloparallax">
        <div class="bienvenido">
            <h1>Datos del usuario</h1>
            <table class="accounttable">
                <tr>
                    <th>Nombre del usuario</th>
                    <td><?= $User['name']." ".$User['surname'] ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $User['email'] ?></td>
                </tr>
                <tr>
                    <th>Tag</th>  
                    <td><?= $User['tag'] ?></td>
                </tr>
                <tr>
                    <th>Último registro</th>  
                    <td><?php if(isset($LastLog)){ echo $LastLog['time']; }elseif(!isset($LastLog)){ echo "Hace más de 7 dias o nunca"; } ?></td>
                </tr>
            </table>
            <div class="chart-container">
                <canvas id="userLogChart"></canvas>
            </div>
            <h2 class="Hello-title">Horario habilitado</h2>
            <?php if($User['from_time'] == '00:00:00' && $User['to_time'] == '23:59:59'): ?>
                <h2 class="Hello-title">Siempre</h2>
            <?php else: ?> 
                <table class="accounttable">
                    <tr>
                        <th>Desde</th>  
                        <td><?= $User['from_time'] ?></td>
                    </tr>
                    <tr>
                        <th>Hasta</th>  
                        <td><?= $User['to_time'] ?></td>
                    </tr>
                </table>
            <?php endif; ?>
            <p><?= session()->getFlashdata('message') ?><?= session()->getFlashdata('error') ?></p>
            <a href="<?= base_url('Users/Edit/'.$User['UserId']); ?>"><button class="custom-button">Editar Usuario</button></a>
            <a href="<?= site_url('Users/Delete/'.$User['UserId']) ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?')"><button class="custom-button">Borrar usuario</button></a>
        </div>
    </div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('userLogChart');
            const chartData = JSON.parse('<?= html_entity_decode($chartData ?? 'null'); ?>');
            if (ctx && chartData) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: chartData.datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: 'rgba(255, 255, 255, 0.8)'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            },
                            x: {
                                 ticks: {
                                    color: 'rgba(255, 255, 255, 0.8)'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(255, 255, 255, 0.8)'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Actividad del Usuario (Últimos 7 Días)',
                                color: 'rgba(255, 255, 255, 0.9)',
                                font: {
                                    size: 18
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>