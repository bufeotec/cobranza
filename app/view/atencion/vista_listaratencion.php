<?php
?>

<!-- Modal -->
<div class="modal fade" id="idmodalnuevoatencionCenter" tabindex="-1" aria-labelledby="idmodalnuevoatencionCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="idmodalnuevoatencionCenterLabel">Nueva Atención</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form_nuevoatencion">
                <div class="modal-body" style="height: 300px; overflow: auto;">
                    <input type="hidden" class="form-control" id="idatencion" name="idatencion" value="0">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="dni"
                                        name="dni"
                                        placeholder="Ingrese DNI"
                                        maxlength="11"
                                        autofocus
                                        required
                                        title="Ingrese solo números (máximo 11 dígitos)"
                                >



                            </div>
                        </div>
                        <div class="col-md-6">
                            <button
                                onclick="buscar_dni_api()"
                                style="width: 100%; margin-top: 30px"
                                type="button"
                                id="idbtnbuscarcliente"
                                class="btn btn-primary">
                                Buscar Cliente
                            </button>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="area" class="form-label">Área</label>
                            <select class="form-select" id="area" name="area">
                                <option value="" selected>Seleccione</option>
                                <option value="Secretaria">Secretaria</option>
                                <option value="Gerencia">Gerencia</option>
                                <option value="Ventas">Ventas</option>
                                <option value="Administración">Administración</option>
                                <option value="Soporte">Soporte</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="motivo" class="form-label">Motivo</label>
                            <input type="text" class="form-control" id="motivo" name="motivo" placeholder="Ingrese motivo">
                        </div>

                        <div class="col-md-12">
                            <label for="observacion" class="form-label">Observación</label>
                            <textarea class="form-control" id="observacion" name="observacion" rows="1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="idbtnguardar_atencion">Guardar</button>
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
        <button class="btn btn-primary me-2"
                data-bs-toggle="modal"
                data-bs-target="#idmodalnuevoatencionCenter"
                onclick="limpiar_formularioatencion()">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Atención
        </button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm small" id="dataTable">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th style="display:none;">ID</th> <!-- oculto desde HTML -->
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Motivo</th>
                                <th>Observación</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $a = 1;
                                    foreach ($atencion as $b) { ?>
                                        <tr>
                                            <td><?= $a ?></td>
                                            <td style="display:none;"><?= $b->id_atencion ?></td>
                                            <td>
                                                <div class="fw-bold"><?= date("d/m/Y", strtotime($b->atencion_fecha)) ?></div>
                                                <div class="text-muted small"><?= date("H:i", strtotime($b->atencion_fecha)) ?></div>
                                            </td>
                                            <td style="max-width:150px; white-space:normal; word-wrap:break-word;">
                                                <div class="fw-bold"><?= htmlspecialchars($b->atencion_nombre) ?></div>
                                                <div class="text-muted small"><?= htmlspecialchars($b->atencion_dni) ?></div>
                                                <div class="badge bg-info text-dark"><?= htmlspecialchars($b->atencion_area) ?></div>
                                            </td>
                                            <td style="max-width:300px; white-space:normal; word-wrap:break-word;">
                                                <?= htmlspecialchars($b->atencion_motivo) ?>
                                            </td>
                                            <td style="max-width:300px; white-space:normal; word-wrap:break-word;">
                                                <?= htmlspecialchars($b->atencion_observacion) ?>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <button
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#idmodalnuevoatencionCenter"
                                                    class="btn btn-sm btn-warning btn"
                                                    onclick="cambiar_texto_formulario('idmodalnuevoatencionCenterLabel', 'Editar Atencion');
                                                            almacenareditar_formularioatencion(
                                                            <?= $b->id_atencion;?>,
                                                            '<?= $b->atencion_dni;?>',
                                                            '<?= $b->atencion_nombre;?>',
                                                            '<?= $b->atencion_area;?>',
                                                            '<?= $b->atencion_motivo;?>',
                                                            '<?= $b->atencion_observacion;?>')"
                                                    ><i class="fas fa-edit alt"></i>
                                                </button>

                                                <button
                                                    type="submit"
                                                    id="idbtnguardar_atencion"
                                                    onclick="preguntar('¿Está seguro que desea Eliminar la Atención?','eliminar_atencion','Si','No', <?= $b->id_atencion?>)"
                                                    class="btn btn-sm btn-danger btn"
                                                    ><i class="fas fa-trash-alt"></i>
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

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>atencion.js"></script>
<script>
    $(document).ready(function(){
        $("#form_nuevoatencion").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            guardar_atencion(formData);
        });
    });
</script>