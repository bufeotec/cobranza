<?php
?>

<!-- Modal Agregar categoria -->
<div class="modal fade" id="idmodalagregarcategoria_vistadetallebeneficio" data-idbeneficio="<?= $id_beneficio ?>" tabindex="-1" aria-labelledby="idmodalagregarcategoria_vistadetallebeneficioLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Seleccione Categoria:</label>
                    <select id="idselectcategoria" class="form-control" onchange = "onchange_selectcategoria(this)">
                        <?php foreach ($categoria as $tc): ?>
                            <option
                                data-service='<?= json_encode($tc, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'
                                value="<?php echo $tc->id_categoria ?>"
                            ><?php echo $tc->categoria_nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Precio Normal: <strong id="idlableprecionormal">0.00</strong></label><br>
                    <label for="recipient-name" class="col-form-label">Precio Socio: <strong id="idlablepreciosocio">0.00</strong></label><br>
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

<div class="container-fluid py-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <div>
            <button class="btn btn-warning me-2">
                <i class="fas fa-edit"></i>  Editar Beneficio
            </button>
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#idmodalagregarcategoria_vistadetallebeneficio" onclick="limpiar_inputsmodal()">
                <i class="bi bi-plus-circle me-1"></i> Seleccionar Categoria
            </button>
        </div>
    </div>

    <!-- Bloque de Información en filas/columnas -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white fw-bold">
            Información General
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <p class="text-muted mb-1">Nombre Beneficio:</p>
                    <p class="fw-semibold"><?= $beneficios->beneficio_nombre?></p>
                </div>

                <div class="col-md-4">
                    <p class="text-muted mb-1">Estado:</p>
                    <span class="badge bg-success">
                        <?php if($beneficios->beneficio_estado == 1): ?>
                            <span class="">Activo</span>
                        <?php else: ?>
                            <span class="">Inactivo</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Cagetorías relacionados al Beneficio</h5>
            <div class="table-responsive">
                <table class="table align-middle table-hover" id="dataTable">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Categoria</th>
                        <th>Cant</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($beneficios_categoria as $b): ?>
                            <tr>
                                <td><?= $b->id_categoriabeneficio ?></td>
                                <td><?= htmlspecialchars($b->categoria_nombre) ?></td>
                                <td><?= htmlspecialchars($b->categoriabeneficio_cant." ". $b->tipobenificios_nombre) ?></td>
                                <td >
                                    <?php if($b->categoriabeneficio_estado == 1): ?>
                                        <span class="">Activo</span>
                                    <?php else: ?>
                                        <span class="">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-flex justify-content-center">
                                    <button
                                        data-bs-toggle="modal"
                                        data-bs-target="#idmodalagregarcategoria_vistadetallebeneficio"
                                        class="btn btn-sm btn-warning btn"
                                        onclick="cambiar_texto_formulario('exampleModalLabel', 'Editar Categoría');
                                                almacenareditar_categoriabeneficio(
                                        <?= $b->id_categoriabeneficio;?>,
                                                '<?= $b->categoriabeneficio_idcategoria;?>',
                                                '<?= $b->categoriabeneficio_cant;?>')"
                                        ><i class="fas fa-edit"></i>
                                    </button>

                                    <button
                                        onclick="preguntar('¿Está seguro que desea Eliminar la Categoría?','eliminar_categoriabeneficio','Si','No', <?= $b->id_categoriabeneficio?>)"
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

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>beneficios_detalle.js"></script>
<script>
    $(document).ready(function() {
        onchange_selectcategoria($("#idselectcategoria")[0]);
    });

</script>