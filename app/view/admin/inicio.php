<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 14/10/2020
 * Time: 21:54
 */
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?>
        </h1>
    </div>

    <!-- Row: Tarjetas resumen -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-info text-white text-center">
                    <h3 class="font-weight-light my-2">👋 Bienvenido al Sistema de Cobranza</h3>
                </div>
                <div class="card-body text-center">
                    <p class="lead">Administra tus clientes, registra pagos y mantén tus finanzas bajo control de manera rápida y sencilla.</p>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-primary shadow-sm">
                                <div class="card-body">
                                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                    <h5>Clientes</h5>
                                    <p>Gestiona la información de tus clientes de forma ordenada.</p>
                                    <a href="#" class="btn btn-sm btn-primary">Ver clientes</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-success shadow-sm">
                                <div class="card-body">
                                    <i class="fa fa-money-bill fa-2x text-success mb-2"></i>
                                    <h5>Pagos</h5>
                                    <p>Registra y controla los pagos recibidos en tiempo real.</p>
                                    <a href="#" class="btn btn-sm btn-success">Registrar pago</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-warning shadow-sm">
                                <div class="card-body">
                                    <i class="fa fa-chart-line fa-2x text-warning mb-2"></i>
                                    <h5>Reportes</h5>
                                    <p>Obtén reportes detallados de tus cobranzas y estados de cuenta.</p>
                                    <a href="#" class="btn btn-sm btn-warning text-white">Generar reporte</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-center small text-muted">
                    BufeoTec Company © 2025 – Sistema de Cobranza
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End Page Content -->


<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>atencion.js"></script>
<!-- Librería Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('sociosPorMesChart').getContext('2d');
        const sociosPorMesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    "Oct 2024","Nov 2024","Dic 2024",
                    "Ene 2025","Feb 2025","Mar 2025","Abr 2025",
                    "May 2025","Jun 2025","Jul 2025","Ago 2025","Sep 2025"
                ],
                datasets: [{
                    label: 'Cantidad de Socios',
                    data: [12, 19, 14, 23, 18, 27, 30, 25, 22, 28, 32, 35],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx2 = document.getElementById('sociosPorRubroChart').getContext('2d');
        const sociosPorRubroChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ["Comercio", "Industria", "Servicios"],
                datasets: [{
                    data: [45, 30, 25], // porcentajes ficticios
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',   // azul
                        'rgba(75, 192, 192, 0.7)',   // verde
                        'rgba(255, 206, 86, 0.7)'    // amarillo
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>