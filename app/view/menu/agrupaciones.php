<!--Modal Agregar Grupo-->
<div class="modal fade" id="gestionGrupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
				<button type="button" class=" btn-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="grupo_nombre" class="col-form-label">Nombre del Grupo</label>
								<input class="form-control" type="hidden" id="id_grupo" name="id_grupo" readonly>
								<input class="form-control" type="text" name="grupo_nombre" id="grupo_nombre" maxlength="20" placeholder="Ingrese Información...">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="grupo_orden" class="col-form-label">Orden de Aparación</label>
								<input class="form-control" type="text" name="grupo_orden" id="grupo_orden" maxlength="11" onkeyup="validar_numeros(this.id)" placeholder="Ingrese Información...">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="grupo_mostrar" class="col-form-label">¿Mostrar en Navegación?</label>
								<select id="grupo_mostrar" class="form-control" onchange="cambiar_color_estado('grupo_mostrar')">
									<option value="1" style="background-color: #17a673; color: white;" selected>SI</option>
									<option value="0" style="background-color: #e74a3b; color: white;">NO</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="grupo_estado" class="col-form-label">Estado</label>
								<select name="grupo_estado" id="grupo_estado" class="form-control" onchange="cambiar_color_estado('grupo_estado')">
									<option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
									<option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="grupo_icono" class="col-form-label">Icono <a href="<?= _SERVER_;?>menu/iconos" target="_blank">(Iconos Aquí)</a></label>
								<input class="form-control" type="text" name="grupo_icono" id="grupo_icono" placeholder="Ingrese Información..." value="fa fa-">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>-->
				<button type="button" class="btn btn-success" id="btn-grupo" onclick="gestionar_grupo()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="gestionRestricciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestión de Restricciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Roles con Restricción a Opción: <span id="nombre_nombre"></span></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-capitalize">
                                                <tr>
                                                    <th>Rol</th>
                                                    <th>Descripción</th>
                                                    <th>¿Con Acceso?</th>
                                                    <th>Acción</th>
                                                </tr>
                                                </thead>
                                                <tbody id="llenar_permisos_grupo">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h2 class="m-0 font-weight-bold text-primary">Agrupaciones</h2>
                <button data-toggle="modal" data-target="#gestionGrupo" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Menú'); agregacion_menu(); limpiar_grupo()" class="btn btn-sm  btn-success "><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Grupo</button>
            </div> <hr>
            <div class="card-body table-responsive">
                <table class="table table-striped" >
                    <thead class="text-capitalize">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Orden</th>
                        <th>Mostrar</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="llenar_permisos_grupo">
					<?php
					$contador = 1;
					foreach ($grupos_v as $gru){
						?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><i class="<?=$gru->grupo_icono;?>"></i>&nbsp;<?=$gru->grupo_nombre;?></td>
                            <td><?=$gru->grupo_orden;?></td>
                            <td>
                                <?php
                                if($gru->grupo_mostrar == 1){
                                    $pregunta = 'Sí';
								}else{
									$pregunta = 'No';
								}
                                ?>
                                <?=$pregunta?>
                            </td>
                            <td>
								<?php
								if($gru->grupo_estado == 1){
									$estado = 'Activo';
								}else{
									$estado = 'Desactivado';
								}
								?>
                                <?=$estado?>
                            </td>
                            <td>
                                <a data-toggle="modal" data-target="#gestionGrupo"  class="btn btn-sm btn-warning text-white" onclick="edicion_grupo(<?= $gru->id_grupo ?>,'<?= $gru->grupo_nombre ?>','<?= $gru->grupo_icono ?>',<?= $gru->grupo_orden ?>,<?= $gru->grupo_mostrar ?>,<?= $gru->grupo_estado ?>)"><i class="fa fa-pencil"></i> </a>
                                <a data-toggle="modal" onclick="edit_permisos_agrup(<?= $gru->id_grupo ?>,'<?= $gru->grupo_nombre ?>')" title="Ver Restricciones" data-target="#gestionRestricciones" class="btn btn-sm btn-danger btn"><i class="fa-solid fa-circle-exclamation"></i></a>
                            </td>
                        </tr>
						<?php
						$contador++;
					}
					?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>menu.js"></script>