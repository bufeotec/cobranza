<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>
<!-- Modal Agregar Nuevo Menú-->



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <a href="<?= _SERVER_;?>Socios/afiliacion"><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus  text-white-50"></i> Nuevo Socio</button></a>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listado de Afiliados</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="dataTable">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th style="display:none;">ID</th> <!-- oculto desde HTML -->
                                    <th>Logo</th>
                                    <th>Razón social</th>
                                    <th>Cat</th>
                                    <th>Rubro</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a = 1;
                                foreach ($socios as $socio) { ?>
                                    <tr>
                                        <td><?= $a ?></td>
                                        <td style="display:none;"><?= $socio->id_socio ?></td>
                                        <td>
                                            <img src=" <?=_SERVER_ . $socio->socio_rutalogo ?>" alt="Logo" class="img-fluid" style="width: 50px;">
                                        </td>
                                        <td><?= htmlspecialchars($socio->cliente_razonsocial) ?></td>
                                        <td><?= htmlspecialchars($socio->categoria_nombre) ?></td>
                                        <td><?= htmlspecialchars($socio->rubro_nombre) ?></td>
                                        <td><span class="btn btn-sm btn-success" style="border-radius: 20px;font-size: 9pt">Activo</span></td>
                                        <td class="d-flex justify-content-center">
                                            <div class="text-end">
                                                <div class="dropstart d-inline-block">
                                                    <!-- Botón: tres puntos verticales -->
                                                    <button class="btn btn-primary btn-sm dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false" title="Acciones">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>

                                                    <!-- NOTA: auto-close fuera, así no se cierra el padre al usar submenú -->
                                                    <ul class="dropdown-menu" data-bs-auto-close="outside">
                                                        <li><a class="dropdown-item" href="<?= _SERVER_ ?>Socios/vista_detalle_afiliacion_socio/<?= $socio->id_socio ?>"><i class="fa fa-eye ver_detalle"></i> Detalle del Socio</a></li>
                                                        <li><a class="dropdown-item" href="<?= _SERVER_ ?>Socios/afiliacion/<?= $socio->id_socio ?>"> <i class="fas fa-edit"></i> Editar Socio</a></li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="<?= _SERVER_ ?>Socios/vista_detalle_beneficiousuo_socio/<?= $socio->id_socio ?>">
                                                                <i class="fa-solid fa-receipt me-2"></i> Detalle del Beneficio
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $a++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>

<style>
    /* Qitar el caret del botón principal */
    .no-caret.dropdown-toggle::after { display: none; }

    /* Estética opcional */
    .dropdown-menu{
        min-width: 220px;
        border-radius: .6rem;
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        padding: .35rem 0;
    }
    .dropdown-item:hover { background-color: #0d6efd; color: #fff; }
</style>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>servicio.js"></script>


<script>

    $(document).ready(function() {
        // Editar socio
        $('.editar-socio').click(function() {
            var id_socio = $(this).data('id');
            window.location.href = '<?= _SERVER_ ?>socios/editar/' + id_socio;
        });
    });

</script>





