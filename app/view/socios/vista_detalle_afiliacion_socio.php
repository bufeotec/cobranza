
<?php


?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="<?= _SERVER_ ?>Socios/vista_afiliacion"><i class="fa fa-arrow-left fs-2" aria-hidden="true"> </i></a>
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    <a target="_blank" href='<?= _SERVER_ ?>Socios/generarpdf/<?= $socios->id_socio ?>'><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"> Generar PDF</button></a>
</div>  

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row  ">
                        <div class="col-sm-2">
                            <img src="<?= _SERVER_ . _STYLES_ALL_?>logotextBu.png" alt="logo" class="w-100 h-100">
                        </div>
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary text-center">FICHA DE SOCIO</h6>
                        </div>
                        <!-- <div class="col-sm-2">
                            <a href="<?= _SERVER_ ?>Socios/vista_afiliacion"> regresar</a>
                        </div> -->

                    </div>
                </div>
                <div class="card-body">
                    <form id="idformularioafiliado">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_tipo" class="col-form-label"><b>Tipo</b></label><br>
                                    <label><?= $socios->socio_tipo_persona;?></label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_ruc" class="col-form-label"><b>Nro de RUC</b></label><br>
                                    <label><?= $socios->socio_num_ruc;?></label>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="empresa_razon_social" class="col-form-label"><b>Razón Social</b></label><br>
                                    <label><?= $socios->socio_razon_social;?></label>
                                    
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_nombre_comercial" class="col-form-label"><b>Nombre Comercial</b></label><br>
                                    <label><?= $socios->socio_nombre_comercial;?></label>
                                    
                                </div>
                            </div>
                            <!-- Departamento -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="selectDepartamento" class="col-form-label"><b>Departamento</b></label><br>
                                    <label><?= $socios->socio_departamento;?></label>
                                </div>
                            </div>

                            <!-- Provincia -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="selectProvincia" class="col-form-label"><b>Provincia</b></label><br>
                                    <label><?= $socios->socio_provincia;?></label>

                                </div>
                            </div>

                            <!-- Distrito -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="selectDistrito" class="col-form-label"><b>Distrito</b></label><br>
                                    <label><?= $socios->socio_distrito;?></label>

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="empresa_direccion" class="col-form-label"><b>Dirección</b></label><br>
                                    <label><?= $socios->socio_direccion;?></label>
                                    
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" >
                                    <label for="empresa_fundacion" class="col-form-label"><b>Fecha de fundación</b></label><br>
                                    <label><?= isset($socios->socio_fecha_fundacion) ? date('Y-m-d', strtotime($socios->socio_fecha_fundacion)) : '' ?></label>
                                    
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="empresa_sector" class="col-form-label"><b>Sector</b></label><br>
                                    <label><?= $socios->sector_nombre;?></label>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id_rubro" class="col-form-label"><b>Rubro</b></label><br>
                                    <label><?= $socios->rubro_nombre;?></label>


                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="empresa_descripcion" class="col-form-label"><b>Breve descripción de la actividad de la empresa</b></label><br>
                                    <label id="empresa_descripcion" name="empresa_descripcion" ><?= $socios->socio_descripcion_actividad;?></label>

                                </div>
                            </div>
                            <!-- Teléfono 1 -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_telefono1" class="col-form-label"><b>Teléfono 1</b></label><br>
                                    <label><?= $socios->socio_telefono1;?></label>
                                    
                                </div>
                            </div>

                            <!-- Teléfono 2 -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_telefono2" class="col-form-label"><b>Teléfono 2</b></label><br>
                                    <label><?= $socios->socio_telefono2;?></label>
                                </div>
                            </div>

                            <!-- Celular 1 -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_celular1" class="col-form-label"><b>Celular 1</b></label><br>
                                    <label><?= $socios->socio_celular1;?></label>
                                </div>
                            </div>

                            <!-- Celular 2 -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="empresa_celular1" class="col-form-label"><b>Celular 2</b></label><br>
                                    
                                </div>
                            </div>
                            <!-- Página Web -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="empresa_paginaweb" class="col-form-label"><b>Página web</b></label><br>
                                    <label><?= $socios->socio_pagina_web;?></label>
                                    
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="empresa_email" class="col-form-label"><b>Email</b></label><br>
                                    <label><?= $socios->socio_correo;?></label>
                                </div>
                            </div>

                            <h6 class=" mb-3 fw-bold">Principales Ejecutivos</h6>
                            <!-- Apellidos y Nombres -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="empresa_apellidos" class="col-form-label"><b>Apellidos y Nombres</b></label><br>
                                    <label><?= $socios->socio_nombre_ejecutivo;?></label>
                                    
                                </div>
                            </div>

                            <!-- Cargo -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="idinputcargoafiliado" class="col-form-label"><b>Cargo</b></label><br>
                                    <label><?= $socios->socio_cargo_ejecutivo;?></label>
                                </div>
                            </div>
                            <!-- Onomástico -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="idinput_ornomasticoafiliado" class="col-form-label"><b>Onomástico</b></label><br>
                                    <label><?= $socios->socio_ornomastico;?></label>
                                    
                                </div>
                            </div>

                            <!-- Email del ejecutivo -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="idinput_emailejecutivo" class="col-form-label"><b>Email</b></label><br>
                                    <label><?= $socios->socio_email_ejecutivo;?></label>
                                    
                                </div>
                            </div>

                            <!-- Actividades de la Empresa -->
                            <div class="form-group mt-4">
                                <h6 class="mb-3 fw-bold ">Actividades que realiza la Empresa</h6>


                                <?php
                                // Definir todas las posibles actividades
                                $todas_actividades = [
                                        'Fabrica',
                                        'Importa',
                                        'Exporta',
                                        'Comercio',
                                        'Servicio'
                                ];

                                // Obtener actividades activas del socio
                                $actividades_activas = [];
                                if(count($actividadsocios) > 0) {
                                    foreach($actividadsocios as $actividad) {
                                        if(in_array($actividad->socio_actividad_id_socio, [1,2,3,4,5])) {
                                            $actividades_activas[] = $actividad->actividad_nombre;
                                        }
                                    }
                                }
                                ?>

                                <div class="d-flex flex-wrap justify-content-center gap-4">
                                    <?php foreach($todas_actividades as $actividad): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                    <?= in_array($actividad, $actividades_activas) ? 'checked' : '' ?>
                                            >
                                            <label class="form-check-label">
                                                <?= $actividad ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>


                            <br><br>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label"><b>Categoria</b></label><br>
                                    <label><?= $socios->categoria_nombre;?></label>
                                    <!-- <input class="form-control" type="text" value="<?=  $socios->categoria_nombre ?>" disabled> -->
                                    <!-- <select class="form-control" id="idselect_categoriaafiliado" name="idselect_categoriaafiliado" required>
                                        <option value="">Seleccione</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label"><b>Cuota Mensual</b></label><br>
                                <label><?= $socios->categoria_cuota;?></label>

                            </div>

                            <div class="col-md-3">
                                <label class="form-label"><b>Cuota de ingreso</b></label><br>
                                <label><?= $socios->categoria_inscripcion;?></label>
                            </div>


                            <div class="col-md-3">
                                <label class="form-label"><b>Medio de pago</b></label><br>
                                <label><?= $socios->socio_tipo_pago;?></label>
                                <!-- <select type="text" class="form-control">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="plin/yape">Plin / Yape</option>
                                    <option value="transferencia">Transferencia</option>
                                </select> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>