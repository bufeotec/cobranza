<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>
<!-- Modal Agregar Nuevo Menú-->
<div class="modal fade" id="gestionCategorias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Nombre de la Categoría</label>
                                <input class="form-control" type="hidden" id="id_categoria" maxlength="11" readonly>
                                <input class="form-control" type="text" id="categoria_nombre" maxlength="100">
                            </div>
                        </div>
                        <div class="col-lg-6" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Inscripción</label>
                                <input class="form-control" type="text" value="50" id="categoria_inscripcion" maxlength="10">
                            </div>
                        </div>
                        <div class="col-lg-6"  >
                            <div class="form-group">
                                <label class="col-form-label">Cuota ordinaria</label>
                                <input class="form-control" type="text" id="categoria_cuota" maxlength="10">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Cuota anual</label>
                                <input class="form-control" type="text" id="categoria_cuota_anual" maxlength="10">
                            </div>
                        </div>
                        <div class="col-lg-6" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Horas de auditorio</label>
                                <input class="form-control" type="text" id="categoria_horas_auditorio" value="5" maxlength="10">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Estado</label>
                                <select id="categoria_estado" class="form-control" onchange="cambiar_color_estado('categoria_estado')">
                                    <option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
                                    <option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="button" class="btn btn-success" id="btn-agregar-categoria" onclick="gestionar_categoria()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <button data-toggle="modal" data-target="#gestionCategorias" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nueva Categoría'); agregacion_categoria()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nueva Categoría</button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Categorías Registradas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cuota Ordinaria</th>
                                <th style="display: none;">Inscripción</th>
                                <th>Cuota Anual</th>
                                <th style="display: none;">Horas de auditorio</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($categorias as $m){
                                $estado = "DESHABILITADO";
                                $estilo_estado = "class=\"texto-deshabilitado\"";
                                if($m->categoria_estado == 1){
                                    $estado = "HABILITADO";
                                    $estilo_estado = "class=\"texto-habilitado\"";
                                }
                                ?>
                                <tr>
                                    <td><?= $m->id_categoria;?></td>
                                    <td><?= $m->categoria_nombre;?></td>
                                    <td><?= $m->categoria_cuota;?></td>
                                    <td style="display: none;"><?= $m->categoria_inscripcion;?></td>
                                    <td><?= $m->categoria_cuota_anual;?></td>
                                    <td style="display: none;"><?= $m->categoria_horas_auditorio;?></td>
                                    <td <?= $estilo_estado;?>><?= $estado;?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#gestionCategorias" class="btn btn-sm btn-warning btne" onclick="cambiar_texto_formulario('exampleModalLabel', 'Editar Categoría'); edicion_categoria(<?= $m->id_categoria;?>, '<?= $m->categoria_nombre;?>', '<?= $m->categoria_cuota;?>', '<?= $m->categoria_inscripcion;?>', '<?= $m->categoria_cuota_anual;?>', <?= $m->categoria_horas_auditorio;?>, <?= $m->categoria_estado;?>)" >Editar</button>
                                    </td>
                                </tr>
                                <?php
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
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>categoria.js"></script>