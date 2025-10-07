<?php
?>

<!-- Modal Agregar Beneficio -->
<div class="modal fade" id="idmodalnuevobeneficio_vistabeneficio" tabindex="-1" aria-labelledby="idmodalnuevobeneficio_vistabeneficioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="idmodalnuevobeneficio_vistabeneficioLabel">Nuevo Beneficio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="idformulariomodalbeneficio">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="idinputbeneficio_nombre">Nombre Beneficio</label>
                            <input type="text" class="form-control" name="idinputbeneficio_nombre" id="idinputbeneficio_nombre" required>
                        </div>
                        <div class="col-md-6"
                            <label for="idinput_tipobeneficio">Tipo Beneficio</label>
                            <select class="form-control" id="idinput_tipobeneficio" name="idinput_tipobeneficio" required>
                                <?php foreach ($tipobeneficios as $tc): ?>
                                    <option
                                            data-service='<?= json_encode($tc, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'
                                            value="<?php echo $tc->id_tipobeneficio ?>"
                                    ><?php echo $tc->tipobenificios_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="idinputbeneficio_descripcion">Beneficio Descripción</label>
                            <textarea class="form-control" id="idinputbeneficio_descripcion" name="idinputbeneficio_descripcion"></textarea>
                        </div>

                        <input type="hidden" class="form-control" name="id_beneficio" id="id_beneficio" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="idbtnguardar_beneficio">Guardar</button>
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
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#idmodalnuevobeneficio_vistabeneficio" onclick="limpiar_inputsmodal_vistabeneficio()">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Beneficio
        </button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Listado de Benficios</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="dataTable">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Beneficio</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($beneficios as $b): ?>
                                <tr>
                                    <td><?= $b->id_beneficio ?></td>
                                    <td><?= htmlspecialchars($b->beneficio_nombre) ?></td>
                                    <td><?= htmlspecialchars($b->tipobenificios_nombre) ?></td>
                                    <td >
                                        <?php if($b->beneficio_estado == 1): ?>
                                            <span class="">Activo</span>
                                        <?php else: ?>
                                            <span class="">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-flex justify-content-right">
                                        <a href='<?= _SERVER_ ?>Beneficios/vista_detallebeneficios/<?= $b->id_beneficio ?>' class="btn btn-info btn-sm ver-detalle" data-id="<?= $b->id_beneficio ?>">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <button
                                            data-bs-toggle="modal"
                                            data-bs-target="#idmodalnuevobeneficio_vistabeneficio"
                                            class="btn btn-sm btn-warning btn"
                                            onclick="cambiar_texto_formulario('idmodalnuevobeneficio_vistabeneficioLabel', 'Editar Beneficio');
                                                    almacenareditar_beneficio(
                                                    <?= $b->id_beneficio;?>,
                                                    '<?= $b->beneficio_nombre;?>',
                                                    '<?= $b->beneficio_descripcion;?>',
                                                    <?= $b->beneficio_idtipobenificios;?>)"
                                            ><i class="fas fa-edit"></i>
                                        </button>

                                        <button
                                            onclick="preguntar('¿Está seguro que desea Eliminar el Benificio?','eliminar_beneficioAPI','Si','No', <?= $b->id_beneficio?>)"
                                            class="btn btn-sm btn-danger btn"
                                            ><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>beneficios.js"></script>
<script>
    $(document).ready(function(){
        $("#idformulariomodalbeneficio").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            guardar_beneficio(formData);
        });
    });
</script>