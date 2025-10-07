<?php
?>

<!-- Modal Agregar Evento -->
<div class="modal fade" id="idmodalnuevoeventoCenter" tabindex="-1" aria-labelledby="idmodalnuevoeventoCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header text-black>">
                <h5 class="modal-title mb-0" id="idmodalnuevoeventoCenterLabel">
                    <i class="fas fa-calendar-plus me-2"></i> Nuevo Evento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form_nuevoevento">
                <div class="modal-body">
                    <input type="hidden" id="idevento" name="idevento" value="0">

                    <div class="row g-3">
                        <!-- Nombre Completo -->
                        <div class="col-md-12">
                            <label for="evento_nombre" class="form-label">Nombre Evento</label>
                            <input type="text" class="form-control" id="evento_nombre" name="evento_nombre" placeholder="Ingrese nombre completo" required>
                        </div>

                        <!-- evento_fecha -->
                        <div class="col-md-12">
                            <label for="evento_fecha" class="form-label">Fecha Evento</label>
                            <input type="datetime-local" class="form-control" id="evento_fecha" name="evento_fecha" placeholder="Ingrese la fecha" required>
                        </div>

                        <!-- evento estado -->
                        <div class="col-md-12">
                            <label for="evento_estado">Estado Evento</label>
                            <select id="evento_estado" name="evento_estado" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="1">Programado</option>
                                <option value="2">En Curso</option>
                                <option value="3">Terminado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary" id="idbtnguardar_evento">
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
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#idmodalnuevoeventoCenter" onclick="limpiar_formularioevento()">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Evento
        </button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center" id="dataTable">
                            <thead class="text-capitalize" id="datatable">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="display:none;">ID</th>
                                <th>Nombre de los Eventos</th>
                                <th style="width: 80px;">Estado</th>
                                <th style="width: 160px;">Fecha</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $a = 1;
                                foreach ($eventos as $ea) { ?>
                                    <tr>
                                        <td><?= $a ?></td>
                                        <td style="display:none;"><?= $ea->id_evento ?></td>
                                        <td class="text-start" style="white-space: normal; word-wrap: break-word;">
                                            <div class="fw-bold"><?= htmlspecialchars($ea->evento_nombre) ?></div>
                                        </td>
                                        <td>
                                            <?php if ($ea->evento_estado == 1): ?>
                                                <span class="text-primary">Programado</span>
                                            <?php elseif ($ea->evento_estado == 2): ?>
                                                <span class="text-warning">En Curso</span>
                                            <?php else: ?>
                                                <span class="text-success">Terminado</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="fw-bold"><?= date("d/m/Y", strtotime($ea->evento_fecha)) ?></div>
                                            <div class="text-muted small"><?= date("H:i", strtotime($ea->evento_fecha)) ?></div>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a class="btn btn-outline-primary"
                                                   href="<?= _SERVER_ . 'Evento/vista_listareventosasist/' . $ea->id_evento ;?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#idmodalnuevoeventoCenter"
                                                        class="btn btn-warning"
                                                        onclick="cambiar_texto_formulario('idmodalnuevoeventoCenterLabel', 'Editar Eventos');
                                                                almacenareditar_formularioevento(
                                                                <?= $ea->id_evento;?>,
                                                                '<?= $ea->evento_nombre;?>',
                                                                '<?= $ea->evento_fecha;?>',
                                                                '<?= $ea->evento_estado;?>')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                        type="submit"
                                                        id="idbtnguardar_atencion"
                                                        onclick="preguntar('¿Está seguro que desea Eliminar el Evento?','eliminar_evento','Si','No', <?= $ea->id_evento?>)"
                                                        class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $a++; }

                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>evento.js"></script>
<script>
    $(document).ready(function(){
        $("#form_nuevoevento").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            guardar_evento(formData);
        });
    });
</script>
