<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 30/05/2021
 * Time: 11:23 p. m.
 */
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <!-- Main content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?= _SERVER_ ?>Ventas/vista_ver_ventas_anulados">
                        <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                        <div class="row">
                            <!--<div class="col-lg-3">
                        <label>Estado de Comprobante</label>
                        <select  id="estado_cpe" name="estado_cpe" class="form-control">
                            <option <?= ($estado_cpe == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($estado_cpe == "0")?'selected':''; ?> value="0">Sin Enviar</option>
                            <option <?= ($estado_cpe == "1")?'selected':''; ?> value="1">Enviado Sunat</option>
                        </select>
                    </div>-->
                            <div class="col-lg-3"></div>
                            <div class="col-lg-2">
                                <label for="">Fecha de Inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                            </div>
                            <div class="col-lg-2">
                                <label for="">Fecha Final</label>
                                <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                            </div>
                            <div class="col-lg-2">
                                <button id="idbtnbuscarfechas_ventasanuladas" style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th style="display:none;">idventa</th> <!-- oculto desde HTML -->
                                <th>Fecha</th>
                                <th>Comprobante</th>
                                <th>Serie y Correlativo</th>
                                <th>Total</th>
                                <th>XML</th>
                                <th>CDR</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($bajas as $v) { ?>
                                <tr>
                                    <td><?= $a ?></td>
                                    <td><?= htmlspecialchars(date('Y-m-d', strtotime($v->venta_fecha))) ?></td>
                                    <td style="display:none;"><?= htmlspecialchars($v->id_venta) ?></td> <!-- oculto -->
                                    <td>
                                        <?php
                                        if($v->venta_tipo == "03"){
                                            $tipo_comprobante = "BOLETA";
                                        }elseif ($v->venta_tipo == "01"){
                                            $tipo_comprobante = "FACTURA";
                                        }elseif($v->venta_tipo == "07"){
                                            $tipo_comprobante = "NOTA DE CRÉDITO";
                                        }elseif($v->venta_tipo == "08"){
                                            $tipo_comprobante = "NOTA DE DÉBITO";
                                        }else{
                                            $tipo_comprobante = "--";
                                        }
                                        echo htmlspecialchars($tipo_comprobante)
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($v->venta_serie) ?> - <?= htmlspecialchars($v->venta_correlativo) ?></td>
                                    <td>S/. <?= htmlspecialchars($v->venta_total) ?></td>
                                        <?php
                                        if($v->venta_tipo_envio == 1){?>
                                            <td>
                                                <a type="button" target='_blank' href="<?= _SERVER_.$v->venta_anulado_rutaXML;?>" style="color: blue;" ><i class="fa fa-file-text"></i></a>
                                                <a type="button" download="<?= $v->venta_anulado_rutaXML;?>" href="<?php echo _SERVER_ . $v->venta_anulado_rutaXML;?>" data-toggle="tooltip" title="Descargar"><i class="fa fa-download"></i></a>
                                            </td>
                                            <td><center><a type="button" target='_blank' href="<?= _SERVER_.$v->venta_anulado_rutaCDR;?>" style="color: green" ><i class="fa fa-file"></i></a></center></td>

                                            <?php
                                        }else{ ?>
                                            <td>--</td>
                                            <td>--</td>
                                            <?php
                                        }
                                        ?>
                                    <td><?= $v->venta_anulado_estado_sunat; ?></td>
                                    <td>
                                        <a href="<?= _SERVER_ . 'Ventas/vista_detalleventa/' . $v->id_venta ;?>" class="btn btn-info btn-sm ver-detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $a++;
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
<style>
    /* Qitar el caret del botón principal */
    .no-caret.dropdown-toggle::after { display: none; }

    /* Estética opcional */
    .dropdown-menu{
        min-width: 220px;
        border-radius: .6rem;
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        padding: .35rem 0;
    }
    .dropdown-item:hover { background-color: #0d6efd; color: #fff; }
</style>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>ventas.js"></script>
<!--<script type="text/javascript">-->
<!---->
<!--    $(document).ready(function() {-->
<!--        $("#idbtnbuscarfechas_ventasanuladas").on("click", function() {-->
<!--            let fecha_inicio = $("fecha_inicio").val();-->
<!--            let fecha_final = $("fecha_final").val();-->
<!---->
<!--            $.ajax({-->
<!--                type: "POST",-->
<!--                url: urlweb + "api/ventas/vista_ver_ventas_anulados",-->
<!--                data: {-->
<!--                    fecha_inicio: fecha_inicio,-->
<!--                    fecha_final: fecha_final-->
<!--                },-->
<!--                dataType: 'json',-->
<!--                success: function (r) {-->
<!---->
<!--                },-->
<!--                error: function(xhr, status, error) {-->
<!--                    console.error("Error AJAX:", error);-->
<!--                    respuesta("Error de conexión con base de datos", "warning");-->
<!--                    consultarAPIExterna();-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->

