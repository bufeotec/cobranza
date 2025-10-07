<?php
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?>
        </h1>
        <a href="#" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte
        </a>
    </div>

    <!-- Row: Tarjetas resumen -->
    <div class="row">

        <!-- Empresas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Socios Actuales
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">128</div>
                    </div>
                    <i class="fas fa-building fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Nuevos Socios -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Nuevos Socios
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">7</div>
                    </div>
                    <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Eventos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Eventos del Mes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">14</div>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Asistentes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Visitantes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">560</div>
                    </div>
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>



    </div>

    <!-- Row: Tablas -->
    <div class="row">

        <!-- Fila con un gráfico -->
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <!-- Encabezado -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Socios por Mes (Último Año)</h6>
                    </div>
                    <!-- Cuerpo con el gráfico -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="sociosPorMesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Encabezado -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">Socios por Rubro</h6>
                    </div>
                    <!-- Cuerpo -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="sociosPorRubroChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="me-2"><i class="fas fa-circle text-primary"></i> Comercio</span>
                            <span class="me-2"><i class="fas fa-circle text-success"></i> Industria</span>
                            <span class="me-2"><i class="fas fa-circle text-warning"></i> Servicios</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabla Eventos -->
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-calendar-alt me-2"></i>Próximos Eventos</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Evento</th>
                                <th>Fecha</th>
                                <th>Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Networking Empresarial</td>
                                <td>10/10/2025</td>
                                <td>Lima</td>
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Foro de Innovación</td>
                                <td>15/11/2025</td>
                                <td>Arequipa</td>
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
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