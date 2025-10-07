<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 25/09/2025
 * Time: 23:11
 */
?>
<div class="modal fade" id="modalAdjuntarComprobante" tabindex="-1" role="dialog" aria-labelledby="modalAdjuntarComprobanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" id="formAdjuntarComprobante">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdjuntarComprobanteLabel">Adjuntar Comprobante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Descripción del Comprobante</label>
                                    <input class="form-control" type="text" id="comprobante_descripcion" name="comprobante_descripcion" maxlength="150" placeholder="Ingrese la descripción...">
                                    <input class="form-control" type="hidden" id="comprobante_texto_general" name="comprobante_texto_general" >
                                    <input class="form-control" type="hidden" id="comprobante_monto_general" name="comprobante_monto_general" >
                                    <input class="form-control" type="hidden" id="id_cobranza_b" name="id_cobranza_b">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Archivo</label>
                                    <input class="form-control" type="file" id="comprobante_ruta" name="comprobante_ruta" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Monto</label>
                                <input class="form-control" type="text" id="comprobante_monto" name="comprobante_monto" value="0" onkeyup="validar_numeros_decimales_dos(this.id)">
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Fecha</label>
                                <input class="form-control" type="date" id="comprobante_fecha" name="comprobante_fecha" value="<?= date('Y-m-d');?>" >
                            </div>
                            <div class="col-md-3 text-right">
                                <button style="margin-top: 37px;" type="submit" class="btn btn-success" id="btnGuardarComprobante"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                            </div>
                        </div>
                        <hr>
                        <!-- Tabla para listar comprobantes adjuntos -->
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Monto</th>
                                        <th>Fecha de Pago</th>
                                        <th>Archivo</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tablaComprobantes">
                                    <!-- Aquí se mostrarán los comprobantes relacionados -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este comprobante?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <hr>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Generar Cobranza</h4>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="id_categoria_socio">Socio</label>
                        <select class="form-control" id="id_socio">
                            <option value="">TODOS</option>
                            <?php foreach ($socios as $socio): ?>
                                <option value="<?= $socio->id_socio; ?>" <?php if($id_socio == $socio->id_socio) { echo 'selected';} ?> ><?= $socio->cliente_razonsocial; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="id_categoria_socio">Categoría de Cobro</label>
                        <select class="form-control" id="id_categoria_socio">
                            <option value="">TODOS</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat->id_categoria; ?>" <?php if($id_categoria_socio == $cat->id_categoria) { echo 'selected';} ?> ><?= $cat->categoria_nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="mes">Mes</label>
                        <select class="form-control" id="mes">
                            <option value="" <?php if($mes == "") { echo 'selected';} ?> >TODOS</option>
                            <option value="1" <?php if($mes == "1") { echo 'selected';} ?> >Enero</option>
                            <option value="2" <?php if($mes == "2") { echo 'selected';} ?> >Febrero</option>
                            <option value="3" <?php if($mes == "3") { echo 'selected';} ?> >Marzo</option>
                            <option value="4" <?php if($mes == "4") { echo 'selected';} ?> >Abril</option>
                            <option value="5" <?php if($mes == "5") { echo 'selected';} ?> >Mayo</option>
                            <option value="6" <?php if($mes == "6") { echo 'selected';} ?> >Junio</option>
                            <option value="7" <?php if($mes == "7") { echo 'selected';} ?> >Julio</option>
                            <option value="8" <?php if($mes == "8") { echo 'selected';} ?> >Agosto</option>
                            <option value="9" <?php if($mes == "9") { echo 'selected';} ?> >Septiembre</option>
                            <option value="10" <?php if($mes == "10") { echo 'selected';} ?> >Octubre</option>
                            <option value="11" <?php if($mes == "11") { echo 'selected';} ?> >Noviembre</option>
                            <option value="12" <?php if($mes == "12") { echo 'selected';} ?> >Diciembre</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="anio">Año</label>
                        <select class="form-control" id="anio" name="anio">
                            <option value="" <?php if($anio == "") { echo 'selected';} ?> >TODOS</option>
                            <option value="2025" <?php if($anio == "2025") { echo 'selected';} ?> >2025</option>
                            <option value="2026" <?php if($anio == "2026") { echo 'selected';} ?> >2026</option>
                            <option value="2027" <?php if($anio == "2027") { echo 'selected';} ?> >2027</option>
                            <option value="2028" <?php if($anio == "2028") { echo 'selected';} ?> >2028</option>
                            <option value="2029" <?php if($anio == "2029") { echo 'selected';} ?> >2029</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="" <?php if($estado == "") { echo 'selected';} ?> >TODOS</option>
                            <option value="0" <?php if($estado == "0") { echo 'selected';} ?> >SIN PAGAR</option>
                            <option value="1" <?php if($estado == "1") { echo 'selected';} ?> >PAGADO</option>
                        </select>
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary" onclick="consultar_cobranza();">
                        Consultar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        // Esta vista solo imprime DENTRO del <div class="row"> del layout global.
        ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Listado de Cobranzas Generadas</h4>
                </div>
            </div>
        </div>

        <?php
        if($facturar){
            ?>
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="dataTable2">
                    <thead>
                    <tr>
                        <th style="width: 50px;">N°</th>
                        <th>Socio</th>
                        <th>Categoria</th>
                        <th>Mes</th>
                        <th>Año</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th style="width: 100px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach($clientes as $c){
                        $texto_mod = $c->cliente_razonsocial . ' - Año: ' . $c->cobranza_anho . ' - Mes: ' . $c->cobranza_mes;
                        $estado_pago = "<button type=\"button\" data-toggle=\"modal\" data-target=\"#modalAdjuntarComprobante\" onclick=\"abrirModalComprobante('".$c->id_cobranza."','".$c->cobranza_monto."','".$texto_mod."')\" class=\"btn btn-danger\">SIN PAGAR</button>";
                        if($c->cobranza_estado == 1){
                            $estado_pago = "<button type=\"button\" data-toggle=\"modal\" data-target=\"#modalAdjuntarComprobante\" onclick=\"abrirModalComprobante('".$c->id_cobranza."','".$c->cobranza_monto."','".$texto_mod."')\"  class=\"btn btn-success\">PAGADO</button>";
                        }
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $c->cliente_razonsocial; ?></td>
                            <td><?= $c->categoria_nombre; ?></td>
                            <td><?= $c->cobranza_mes; ?></td>
                            <td><?= $c->cobranza_anho; ?></td>
                            <td>S/. <?= $c->cobranza_monto; ?></td>
                            <td><?= $estado_pago; ?></td>
                            <td>
                                <div class="text-end">
                                    <div class="dropstart d-inline-block">
                                        <!-- Botón: tres puntos verticales -->
                                        <button class="btn btn-primary btn-sm dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false" title="Acciones">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>

                                        <!-- NOTA: auto-close fuera, así no se cierra el padre al usar submenú -->
                                        <ul class="dropdown-menu" data-bs-auto-close="outside">
                                            <li><a class="dropdown-item" target="_blank" href="<?= _SERVER_ . 'Ventas/vista_detalleventa/' . $c->id_venta ;?>"><i class="fa fa-eye ver_detalle"></i> Ver Detalle</a></li>

                                            <li><hr class="dropdown-divider"></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a target="_blank" class="dropdown-item" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf_A4/' . $c->id_venta ;?>"> <i class="fa-solid fa-file-lines me-2"></i> Descargar Pdf A4</a></li>
                                            <li><a target="_blank" class="dropdown-item" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf/' . $c->id_venta ;?>"> <i class="fa-solid fa-receipt me-2"></i> Descargar Tikett</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--EndQ of Main Content-->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>cobranza.js"></script>
<script>
    $(document).ready(function(){
        $("#id_socio").select2();

    });
    // Opcional: enfocar primer campo
    setTimeout(function(){ document.getElementById('id_categoria_socio').focus(); }, 200);

    function consultar_cobranza(){
        var id_categoria_socio = $('#id_categoria_socio').val();
        var mes = $('#mes').val();
        var anio = $('#anio').val();
        var estado = $('#estado').val();
        var id_socio = $('#id_socio').val();
        var ok = true;

        if(ok){
            let ruta = urlweb + "index.php?c=Cobranza&a=listar&id_categoria_socio=" + id_categoria_socio + "&mes=" + mes + "&anio=" + anio + "&estado=" + estado + "&id_socio=" + id_socio;
            location.href = ruta;
        }
    }

    function generar_cobranza(){
        var boton = "btn-generar";
        var id_categoria_socio = $('#id_categoria_socio').val();
        var mes = $('#mes').val();
        var anio = $('#anio').val();
        var ok = true;

        if(id_categoria_socio === "" || id_categoria_socio === null){ ok = false; respuesta("Seleccione una categoría", 'error'); }
        if(mes === "" || mes === null){ ok = false; respuesta("Seleccione un mes", 'error'); }
        if(anio === "" || anio === null){ ok = false; respuesta("Ingrese un año", 'error'); }

        if(ok){
            var cadena = "id_categoria_socio=" + encodeURIComponent(id_categoria_socio) +
                "&mes=" + encodeURIComponent(mes) +
                "&anio=" + encodeURIComponent(anio);
            $.ajax({
                type: "POST",
                url: urlweb + "api/Cobranza/generar_cobranza",
                data: cadena,
                dataType: 'json',
                beforeSend: function(){
                    $("#" + boton).html("Generando...").attr("disabled", true);
                },
                success: function(r){
                    $("#" + boton).attr("disabled", false).html("Generar");
                    switch (r.result.code) {
                        case 1:
                            respuesta(r.result.message || "¡Cobranza generada!", 'success');
                            // Redirige a un listado o dashboard de cobranza si lo tienes
                            setTimeout(function(){ location.href = urlweb + "cobranza/listar"; }, 400);
                            break;
                        case 2:
                            respuesta(r.result.message || "Fallo en el proceso", 'error');
                            break;
                        case 6:
                            respuesta(r.result.message || "Integridad de datos falló", 'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO", 'error');
                    }
                },
                error: function(){
                    $("#" + boton).attr("disabled", false).html("Generar");
                    respuesta("Error de comunicación", 'error');
                }
            });
        }
    }

</script>

