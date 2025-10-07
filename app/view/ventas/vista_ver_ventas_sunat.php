<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 4/09/2025
 * Time: 16:30
 */
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <a href="<?= _SERVER_;?>Ventas/vista_realizar_venta"><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Nueva Venta</button></a>

    </div>

    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <h5 class="card-title mb-4 text-primary fw-bold">📊 Reporte de Ventas SUNAT</h5>

                <form class="row g-3 align-items-end" method="post" action="<?= _SERVER_ . 'Ventas/vista_ver_ventas_sunat';?>">

                    <!-- Fecha Inicio -->
                    <div class="col-md-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                               value="<?= $fecha_inicio;?>" required>
                    </div>

                    <!-- Fecha Fin -->
                    <div class="col-md-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                               value="<?= $fecha_fin;?>" required>
                    </div>

                    <!-- Botón Consultar -->
                    <div class="col-md-3 d-grid">
                        <button type="submit" name="action" value="consultar" class="btn btn-primary">
                            🔍 Consultar
                        </button>
                    </div>

                    <!-- Botón Descargar Excel -->
                    <div class="col-md-3 d-grid">
                        <a target="_blank" href="<?= _SERVER_ . 'index.php?c=Ventas&a=excel_ventas_sunat&fecha_inicio='.$fecha_inicio.'&fecha_fin='.$fecha_fin?>" class="btn btn-success">
                            ⬇️ Descargar Excel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered shadow-sm rounded" id="dataTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th style="display:none;">idventa</th> <!-- oculto desde HTML -->
                                <th>Fecha</th>
                                <th>Comprobante</th>
                                <th>Serie y Correlativo</th>
                                <th>RUC</th>
                                <th>Cliente</th>
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
                            foreach ($arrayventas as $v) { ?>
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
                                    <td>
                                        <?php
                                        echo htmlspecialchars($v->cliente_numero)
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($v->cliente_nombre == ""){
                                            $nombrecliente = $v->cliente_razonsocial;
                                        }else{
                                            $nombrecliente = $v->cliente_nombre;
                                        }
                                        echo htmlspecialchars($nombrecliente)
                                        ?>
                                    </td>
                                    <td>S/. <?= htmlspecialchars($v->venta_total) ?></td>
                                        <?php
                                        if($v->venta_tipo_envio == 1){?>
                                            <td>
                                                <a type="button" target='_blank' href="<?= _SERVER_.$v->venta_rutaXML;?>" style="color: blue;" ><i class="fa fa-file-text"></i></a>
                                                <a type="button" download="<?= $v->venta_rutaXML;?>" href="<?php echo _SERVER_ . $v->venta_rutaXML;?>" data-toggle="tooltip" title="Descargar"><i class="fa fa-download"></i></a>
                                            </td>
                                            <td><center><a type="button" target='_blank' href="<?= _SERVER_.$v->venta_rutaCDR;?>" style="color: green" ><i class="fa fa-file"></i></a></center></td>

                                            <?php
                                        }else{ ?>
                                            <td>--</td>
                                            <td>--</td>
                                            <?php
                                        }
                                        ?>
                                    <td><?= $v->venta_respuesta_sunat; ?></td>
                                    <td>
                                        <div class="text-end">
                                            <div class="dropstart d-inline-block">
                                                <!-- Botón: tres puntos verticales -->
                                                <button class="btn btn-primary btn-sm dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false" title="Acciones">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>

                                                <!-- NOTA: auto-close fuera, así no se cierra el padre al usar submenú -->
                                                <ul class="dropdown-menu" data-bs-auto-close="outside">
                                                    <li><a class="dropdown-item" href="<?= _SERVER_ . 'Ventas/vista_detalleventa/' . $v->id_venta ;?>"><i class="fa fa-eye ver_detalle"></i> Ver Detalle</a></li>

                                                    <li><hr class="dropdown-divider"></li>
                                                    <?php
                                                        if($v->anulado_sunat == 0){
                                                            $date2 = new DateTime(date('Y-m-d H:i:s'));
                                                            $date1 = new DateTime($v->venta_fecha_envio);
                                                            $diff = $date2->diff($date1);
                                                            $dias= $diff->days;

                                                            if($dias <= 3){
                                                                if($v->venta_tipo != "03"){
                                                                    if($v->tipo_documento_modificar != ""){
                                                                        if($v->tipo_documento_modificar == "01"){
                                                                            ?>
                                                                            <li><a
                                                                                        title="Anular"
                                                                                        id="btn_anular<?= $v->id_venta;?>"
                                                                                        type="button"
                                                                                        target="_blank"
                                                                                        class="dropdown-item"
                                                                                        onclick="preguntar('¿Está seguro que desea anular este Comprobante?','comunicacion_baja','Si','No',<?= $v->id_venta;?>)"
                                                                                > <i class="fa fa-ban"></i> Anular Envio
                                                                                </a></li>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                        <li><a
                                                                                    title="Anular"
                                                                                    id="btn_anular<?= $v->id_venta;?>"
                                                                                    type="button"
                                                                                    target="_blank"
                                                                                    class="dropdown-item"
                                                                                    onclick="preguntar('¿Está seguro que desea anular este Comprobante?','comunicacion_baja','Si','No',<?= $v->id_venta;?>)"
                                                                            ><i class="fa fa-ban"></i> Anular Envio
                                                                            </a></li>
                                                                        <?php
                                                                    }
                                                                }
                                                                else if($v->venta_tipo_envio == "2"){
                                                                    ?>
                                                                    <a target="_blank" type="button" title="Anular" id="btn_anular<?= $v->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $v->id_venta;?>, '3')" ><i class="fa fa-ban"></i></a>
                                                                    <?php
                                                                }
                                                            }
                                                        }

                                                        if($v->anulado_sunat == 0 && ($v->venta_tipo == '01' || $v->venta_tipo == '03')){
                                                            ?>
                                                                <li><a
                                                                    href="<?= _SERVER_ ?>Ventas/vista_realizar_nota/<?= $v->id_venta; ?>"
                                                                    title="Genera Una Notda de Debito ó Credito"
                                                                    class="dropdown-item"
                                                                    ><i class="fa fa-clipboard"></i> Generar Nota
                                                                </a></li>
                                                            <?php
                                                        }
                                                    ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a target="_blank" class="dropdown-item" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf_A4/' . $v->id_venta ;?>"> <i class="fa-solid fa-file-lines me-2"></i> Descargar Pdf A4</a></li>
                                                    <li><a class="dropdown-item" href="#"> <i class="fa-solid fa-file-excel me-2"></i> Descargar Excel</a></li>
                                                    <li><a target="_blank" class="dropdown-item" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf/' . $v->id_venta ;?>"> <i class="fa-solid fa-receipt me-2"></i> Descargar Tikett</a></li>
                                                </ul>
                                            </div>
                                        </div>
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
<script src="<?php echo _SERVER_ . _JS_;?>ventas.js?v=<?= time();?>"></script>
