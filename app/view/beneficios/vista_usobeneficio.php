<?php
?>

<!-- Modal Agregar UsoBenficioSocio -->
<div class="modal fade" id="idmodalagregarusoBeneficio_vistausobeneficio" tabindex="-1" aria-labelledby="idmodalagregarusoBeneficio_vistausobeneficioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Uso Beneficio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Seleccione el Socio:</label>
                    <select id="idselectcategoria" class="form-control" onchange = "onchange_selectcategoria(this)">
                        <?php foreach ($socios as $tc): ?>
                            <option
                                    data-service='<?= json_encode($tc, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'
                                    value="<?php echo $tc->id_socio ?>"
                            ><?php echo $tc->cliente_razonsocial ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Cant:</label>
                    <input type="number" class="form-control" id="idinputcantidad" value="0" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="idbtnguardar_categoriabeneficio" onclick="guardar_categoriabeneficio($(this))">Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#idmodalagregarusoBeneficio_vistausobeneficio" onclick="limpiar_inputsmodal_vistabeneficio()">
            <i class="bi bi-plus-circle me-1"></i> Registrar Nuevo Uso
        </button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Todos los Beneficios, usados por cada socio</h6>
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
                            <?php foreach ($beneficiosuso as $b): ?>
                                <tr>
                                    <td><?= $b->id_sociobeneficioacumulado ?></td>
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
<script src="<?php echo _SERVER_ . _JS_;?>beneficio_uso.js"></script>
<script>

</script>

