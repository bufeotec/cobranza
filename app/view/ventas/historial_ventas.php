<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 22/04/2019
 * Time: 12:26
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <hr><h2 class="concss">
            <a href="http://localhost/fire"><i class="fa fa-fire"></i> INICIO</a> >
            <i class="<?php echo $_SESSION['icono'];?>"></i> <?php echo $_SESSION['accion'];?>
        </h2><hr>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-lg-12" style="text-align: center">
                <h4>LISTA DE VENTAS REGISTRADAS SIN ENVIAR A SUNAT</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?= _SERVER_ ?>Ventas/historial_ventas">
                            <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-2">
                                    <label>Tipo de Venta</label>
                                    <select  id="tipo_venta" name="tipo_venta" class="form-control">
                                        <option <?= ($tipo_venta == "")?'selected':''; ?> value="">Seleccionar...</option>
                                        <option <?= ($tipo_venta == "03")?'selected':''; ?> value="03">BOLETA</option>
                                        <option <?= ($tipo_venta == "01")?'selected':''; ?> value="01">FACTURA</option>
                                        <option <?= ($tipo_venta == "07")?'selected':''; ?> value= "07">NOTA DE CRÉDITO</option>
                                        <option <?= ($tipo_venta == "08")?'selected':''; ?> value= "08">NOTA DE DÉBITO</option>
                                    </select>
                                </div>
                                <!--<div class="col-lg-3">
                        <label>Estado de Comprobante</label>
                        <select  id="estado_cpe" name="estado_cpe" class="form-control">
                            <option <?= ($estado_cpe == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($estado_cpe == "0")?'selected':''; ?> value="0">Sin Enviar</option>
                            <option <?= ($estado_cpe == "1")?'selected':''; ?> value="1">Enviado Sunat</option>
                        </select>
                    </div>-->
                                <div class="col-lg-2">
                                    <label for="">Fecha de Inicio</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Fecha Final</label>
                                    <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                                </div>
                                <div class="col-lg-2">
                                    <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                                </div>
                                <div class="col-lg-3">
                                </div>
                                <div class="col-lg-12" style="text-align: center">
                                    <label for="" style="margin-top: 20px;color: black;">COMPROBANTES SIN ENVIAR: <span style="color: red;"><?= count($ventas_cant);?></span><br>
                                        <span style="font-size: 12px;"><strong>*</strong> ENVIAR MÁXIMO 3 DIAS DESPUES LA FECHA DE EMISIÓN</span></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <?php
                    if($filtro) {
                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha de Emision</th>
                                        <th>Comprobante</th>
                                        <th>Serie y Correlativo</th>
                                        <th>Cliente</th>
                                        <th>Forma de Pago</th>
                                        <th>Total</th>
                                        <th>PDF</th>
                                        <th>Estado Sunat</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    $total = 0;
                                    foreach ($ventas as $al){
                                        $stylee="style= 'text-align: center;'";
                                        if ($al->anulado_sunat == 1){
                                            $stylee="style= 'text-align: center; text-decoration: line-through'";
                                        }

                                        if($al->venta_tipo == "03"){
                                            $tipo_comprobante = "BOLETA";
                                        }elseif ($al->venta_tipo == "01"){
                                            $tipo_comprobante = "FACTURA";
                                        }elseif($al->venta_tipo == "07"){
                                            $tipo_comprobante = "NOTA DE CRÉDITO";
                                        }elseif($al->venta_tipo == "08"){
                                            $tipo_comprobante = "NOTA DE DÉBITO";
                                        }else{
                                            $tipo_comprobante = "--";
                                        }
                                        $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                        if($al->venta_respuesta_sunat == NULL){
                                            $mensaje = "Sin Enviar a Sunat";

                                        }else{
                                            $mensaje = $al->venta_respuesta_sunat;
                                        }
                                        if($al->id_tipodocumento == 4){
                                            $cliente = $al->cliente_razonsocial;
                                        }else{
                                            $cliente = $al->cliente_nombre;
                                        }
                                        ?>
                                        <tr <?= $stylee?>>
                                            <td><?= $a;?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                            <td><?= $tipo_comprobante;?></td>
                                            <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                            <td>
                                                <?= $al->cliente_numero;?><br>
                                                <?= $cliente;?>
                                            </td>
                                            <td><?= $al->tipo_pago_nombre;?></td>
                                            <td>
                                                <?= $al->simbolo.' '.$al->venta_total;?>
                                            </td>
                                            <td><center><a type="button" target='_blank' href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf_a4/' . $al->id_venta ;?>" style="color: red" ><i class="fa fa-file-pdf-o"></i></a></center></td>

                                            <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                            <td style="text-align: left">
                                                <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary btne" style="color: white" href="<?php echo _SERVER_. 'ventas/ver_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                                <?php
                                                if($al->anulado_sunat == "0" && $al->venta_tipo == "01" && ($al->venta_tipo_envio == "0" || $al->venta_tipo_envio == "1")){ ?>
                                                    <a id="btn_enviar<?= $al->id_venta;?>" type="button" title="Enviar a Sunat" class="btn btn-sm btn-success btne" style="color: white" onclick="preguntar('¿Está seguro que desea enviar a la Sunat este Comprobante?','enviar_comprobante_sunat','Si','No',<?= $al->id_venta;?>)"><i class="fa fa-check margen"></i></a>
                                                    <?php
                                                }
                                                if($al->venta_tipo == "03" and $al->anulado_sunat == "0"){
                                                    ?>
                                                    <a target="_blank" type="button" id="btn_anular_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta;?>, '1')" ><i class="fa fa-ban"></i></a>
                                                    <?php
                                                }else{
                                                    if($al->anulado_sunat == "1"){ ?>
                                                        <h5 style="color: red">ANULADO, ir a resumen diario para enviar a sunat</h5>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                        $total = $total + $al->pago_total;
                                    }
                                    ?>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>ventas.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var total_soles = <?= number_format($total_soles, 2); ?>;
        $('#total_restante_soles').html("<b>"+total_soles+"</b>");
    });
</script>
