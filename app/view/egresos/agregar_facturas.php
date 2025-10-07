<?php
/**
 * Created by PhpStorm.
 * User: CesarJose39
 * Date: 02/11/2018
 * Time: 0:36
 */
?>

<!-- Content Wrapper. Contains page content -->
<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <hr><h2 class="concss">
            <a href="<?=_SERVER_; ?>"><i class="fa fa-fire"></i> INICIO</a> >
            <a href="<?=_SERVER_; ?>Egresos/egresos"><i class="<?php echo $_SESSION['icono'];?>"></i> <?php echo $_SESSION['controlador'];?></a> >
            <i class="<?php echo $_SESSION['icono'];?>"></i> <?php echo $_SESSION['accion'];?>
        </h2><hr>
    </section>
    <div class="row">
        <div class="col-lg-9"></div>
        <div class="col-lg-3">
            <a type="button" href="<?=_SERVER_; ?>Egresos/listar_comprobantes" class="btn btn-primary" ><i class="fa fa-eye"></i> Ver Comprobantes</a>
        </div>
    </div>
    <!-- Main content -->
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="text-align: center">
                <h5 class="font-weight-bold">AGREGAR FACTURA</h5>
            </div>
        </div><br>
        <form enctype="multipart/form-data" id="comprobantes">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-form-label">TIPO DOCUMENTO</label>
                            <select class="form-control" id= "comprobante_tipo" name="comprobante_tipo">
                                <option value="">Elegir Tipo</option>
                                <option value="boleta">BOLETA</option>
                                <option value="factura">FACTURA</option>
                                <option value="guia_remision">GUIA DE REMISION</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="col-form-label">SERIE</label>
                            <input class="form-control" type="text" id="comprobante_serie" onkeyup="" name="comprobante_serie" maxlength="100" placeholder="Ingrese Numero...">
                            <input  type="hidden" id="datos" name="datos">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="col-form-label">CORRELATIVO</label>
                            <input class="form-control" type="text" id="comprobante_correlativo" onkeyup="" name="comprobante_correlativo" maxlength="100" placeholder="Ingrese Numero...">
                            <input  type="hidden" id="datos" name="datos">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="col-form-label">FECHA EMISIÓN</label>
                            <input class="form-control" type="date" id="comprobante_fecha_emision" name="comprobante_fecha_emision">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-form-label">ADJUNTAR ARCHIVO</label>
                            <input class="form-control" type="file" id="comprobante_archivo" name="comprobante_archivo" maxlength="100">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label">CONCEPTO DEL COMPROBANTE</label>
                            <textarea rows="3" class="form-control" type="text" id="comprobante_concepto" name="comprobante_concepto" maxlength="500" placeholder="Ingrese Información..."></textarea>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-form-label">RUC PROVEEDOR</label>
                            <input class="form-control" type="text" id="comprobante_ruc_proveedor" name="comprobante_ruc_proveedor" placeholder="Ingrese dato...">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-form-label">TIPO PAGO</label>
                            <select class="form-control" onchange="ver(this.value)" id= "comprobante_tipo_pago" name="comprobante_tipo_pago">
                                <option value="">Seleccione</option>
                                <?php
                                foreach($tipo_pago as $tp){
                                    ?>
                                    <option value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <button type="submit" id="btn-guardar_nuevo" class="btn btn-primary submitBtn"><i class="fa fa-save"></i> GUARDAR</button>
                </div>
            </div>
        </form>
    </section>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>egresos.js"></script>

<script>
    $("#comprobantes").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var boton = 'btn-guardar_nuevo';

        var comprobante_tipo = $('#comprobante_tipo').val();
        var comprobante_concepto = $('#comprobante_concepto').val();
        var comprobante_serie = $('#comprobante_serie').val();
        var comprobante_correlativo = $('#comprobante_correlativo').val();
        var comprobante_archivo = $('#comprobante_archivo').val();

        validar_campo_vacio('comprobante_archivo', comprobante_archivo, valor);
        validar_campo_vacio('comprobante_serie', comprobante_serie, valor);
        validar_campo_vacio('comprobante_correlativo', comprobante_correlativo, valor);

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Egresos/guardar_comprobantes",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    cambiar_estado_boton(boton,'Guardando...',true);
                    //$('#btn-guardar_nuevo').attr("disabled",true);
                    //$('#btn-guardar_nuevo').css("opacity",".5");
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito!','success');
                            setTimeout(function () {
                                location.reload()
                            }, 400);
                            break;
                        case 2:
                            respuesta("Fallo el envio, intentelo de nuevo", 'error');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO", 'error');
                    }
                    $('#guardar_comanda').css("opacity","");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        }
    });
</script>