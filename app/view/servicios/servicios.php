<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>
<!-- Modal Agregar Nuevo Menú-->
<div class="modal fade" id="gestionServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label class="col-form-label">Tipo de Categoría</label>
                                <select class="form-control" id="id_servicios_categoria">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($serv_cat as $sc){
                                        echo "<option value='$sc->id_servicio_categoria'>$sc->servicio_categoria_nombre</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Nombre del Servicio</label>
                                <input class="form-control" type="hidden" id="id_servicio" maxlength="11" readonly>
                                <input class="form-control" type="text" id="servicio_nombre" maxlength="100">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Descripción</label>
                                <input class="form-control" type="text" id="servicio_descripcion" maxlength="500">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Precio Normal</label>
                                <input class="form-control" type="text" id="servicio_precio_normal" maxlength="10">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Precio Socio</label>
                                <input class="form-control" type="text" id="servicio_precio_socio" maxlength="10">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Tipo Afectacion</label>
                                <select class="form-control" id="id_servicio_tipo_afectacion" disabled>
                                    <option value="">Seleccione</option>
                                    <option value="1">OP. GRAVADAS</option>
                                    <option value="2" selected>OP. EXONERADAS</option>
                                    <option value="3">OP. INAFECTAS</option>
                                    <option value="4">OP. GRATUITAS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-form-label">Estado</label>
                                <select id="servicio_estado" class="form-control" onchange="cambiar_color_estado('servicio_estado')">
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
                <button type="button" class="btn btn-success" id="btn-agregar-servicio" onclick="gestionar_servicio()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <button data-toggle="modal" data-target="#gestionServicio" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Servicio'); agregacion_servicio()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo Servicio</button>
    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Servicios Registrados</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Tipo Categoría</th>
                                <th>Precio normal</th>
                                <th>Precio socio</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($servicios as $m){
                                $estado = "DESHABILITADO";
                                $estilo_estado = "class=\"texto-deshabilitado\"";
                                if($m->servicio_estado == 1){
                                    $estado = "HABILITADO";
                                    $estilo_estado = "class=\"texto-habilitado\"";
                                }
                                ?>
                                <tr id="filamenu<?= $m->id_servicio;?>">
                                    <td><?= $m->id_servicio;?></td>
                                    <td id="servicionombre<?= $m->id_servicio;?>"><?= $m->servicio_nombre;?></td>
                                    <td id="serviciodesc<?= $m->id_servicio;?>"><?php echo $m->servicio_descripcion;?></td>
                                    <td id="serviciocat<?= $m->id_servicio;?>"><?php echo $m->servicio_categoria_nombre;?></td>
                                    <td id="servicioprecn<?= $m->id_servicio;?>"><?= $m->servicio_precio_normal;?></td>
                                    <td id="servicioprecs<?= $m->id_servicio;?>"><?= $m->servicio_precio_socio;?></td>
                                    <td <?= $estilo_estado;?> id="servicioestado<?= $m->id_servicio;?>"><?= $estado;?></td>
                                    <td id="botonmenu<?= $m->id_servicio;?>">
                                        <button data-toggle="modal" data-target="#gestionServicio" class="btn btn-sm btn-warning btne" onclick="cambiar_texto_formulario('exampleModalLabel', 'Editar Servicio'); edicion_servicio(<?= $m->id_servicio;?>, '<?= $m->servicio_nombre;?>', '<?= $m->servicio_descripcion;?>', '<?= $m->id_servicios_categoria;?>', '<?= $m->servicio_precio_normal;?>', <?= $m->servicio_precio_socio;?>, <?= $m->servicio_estado;?>, <?= $m->servicio_tipoafectacion;?>)" >Editar</button>
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
<script src="<?php echo _SERVER_ . _JS_;?>servicio.js"></script>