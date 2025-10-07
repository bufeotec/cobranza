<?php
?>

<!-- Modal Agregar EventoAsist -->
<div class="modal fade" id="idmodalnuevoeventoasistCenter" tabindex="-1" aria-labelledby="idmodalnuevoeventoasistCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header text-black">
                <h5 class="modal-title mb-0" id="idmodalnuevoeventoasistCenterLabel">
                    <i class="fas fa-calendar-plus me-2"></i> Nuevo Evento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form_nuevoeventoasist">
                <div class="modal-body">
                    <input type="hidden" id="ideventoasit" name="ideventoasit" value="0">

                    <div class="row g-3">
                        <!-- Nombre Completo -->
                        <div class="col-md-6">
                            <label for="eventoasist_nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="eventoasist_nombre" name="eventoasist_nombre" placeholder="Ingrese nombre completo" required>
                        </div>

                        <!-- Empresa -->
                        <div class="col-md-6">
                            <label for="eventoasist_empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control" id="eventoasist_empresa" name="eventoasist_empresa" placeholder="Ingrese empresa" required>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-6">
                            <label for="eventoasist_correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="eventoasist_correo" name="eventoasist_correo" placeholder="correo@ejemplo.com" required>
                        </div>

                        <!-- Celular -->
                        <div class="col-md-6">
                            <label for="eventoasist_celular" class="form-label">Celular</label>
                            <input type="tel" class="form-control" id="eventoasist_celular" name="eventoasist_celular" placeholder="999 999 999" maxlength="15" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary" id="idbtnguardar_eventoasist">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#idmodalnuevoeventoasistCenter" onclick="limpiar_formularioevento()">
            <i class="bi bi-plus-circle me-1"></i> Usuario no Registrado
        </button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="dataTable">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th style="display:none;">IdEventoAsis</th> <!-- oculto desde HTML -->
                                <th style="display:none;">IdSocio</th> <!-- oculto desde HTML -->
                                <th>Nombre Beneficio</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $a = 1;
                                    foreach ($eventoasistlist as $ea) { ?>
                                        <tr class="<?= $ea->asistio == '1' ? 'anulada' : '' ?>">
                                            <td><?= $a ?></td>
                                            <td style="display:none;"><?= $ea->id_eventoasist ?></td>
                                            <td style="display:none;"><?= $ea->id_socio ?></td>
                                            <td style="max-width:150px; white-space:normal; word-wrap:break-word;">
                                                <div class="fw-bold"><?= htmlspecialchars($ea->socio_nombre_comercial) ?></div>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <button
                                                        type="button"
                                                        onclick="preguntar('¿Seguro de <?= $ea->asistio == '1' ? 'Desmarcar' : 'Marcar' ?> la asistencia?', 'agreagrcheck_eventoasit', 'si', 'NO', <?= $ea->id_eventoasist ?>, '<?= $ea->id_socio ?>')"
                                                        class="btn btn-sm <?= $ea->asistio == '1' ? 'btn-danger' : 'btn-success' ?>"
                                                ><i class="<?= $ea->asistio == '1' ? 'fas fa-ban' : 'fas fa-check' ?>"></i>
                                                </button>
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

<style>
    .anulada td {
        text-decoration: line-through;   /* línea de tachado */
        color: #999;                     /* color gris tenue */
        background-color: #f8f9fa;       /* un fondo claro opcional */
    }

</style>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>eventoasit.js"></script>
<script>
    $(document).ready(function(){
        $("#form_nuevoeventoasist").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            guardar_evento(formData);
        });
    });
</script>
