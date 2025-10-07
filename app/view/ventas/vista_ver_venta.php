<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <a href="<?= _SERVER_;?>Ventas/vista_realizar_venta"><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Nueva Venta</button></a>

    </div>

    <!-- /.row (main row) -->
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
                                <th>RUC</th>
                                <th>Cliente</th>
                                <th>Total</th>
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
                                                    <!-- Botón enviar a sunat -->
                                                    <?php

                                                    if($v->venta_estado_sunat == 0){
                                                        ?>
                                                        <li><a
                                                                    data-service='<?= json_encode($v, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'
                                                                    type="button"
                                                                    class="dropdown-item"
                                                                    onclick="preguntar('¿Está seguro que desea Enviar a Sunat este Comprobante?','enviar_comprobante_sunat','Si','No',<?= $v->id_venta;?>, '1')">
                                                                <i class="fa fa-check margen"></i> Enviar a sunat
                                                            </a></li>
                                                        <?php
                                                    }
                                                    ?>

                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a target="_blank" class="dropdown-item" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf_A4/' . $v->id_venta ;?>"> <i class="fa-solid fa-file-lines me-2"></i> Descargar Pdf A4</a></li>
                                                    <li><a target="_blank" class="dropdown-item" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf/' . $v->id_venta ;?>"> <i class="fa-solid fa-receipt me-2"></i> Descargar Ticket</a></li>
                                                </ul>
                                            </div>
                                        </div>


                                        <!--                                        <div class="btn-group" role="group">-->
                                        <!--                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">-->
                                        <!--                                                <i class="fa-solid fa-file-pdf"></i>-->
                                        <!--                                            </button>-->
                                        <!--                                            <ul class="dropdown-menu dropdown-menu-end shadow border rounded" aria-labelledby="btnGroupDrop1">-->
                                        <!--                                                <li>-->
                                        <!--                                                    <a target="_blank" class="dropdown-item" href="">-->
                                        <!--                                                        <i class="fa-solid fa-receipt me-2"></i> Ticket-->
                                        <!--                                                    </a>-->
                                        <!--                                                </li>-->
                                        <!--                                                <li>-->
                                        <!--                                                    <a target="_blank" class="dropdown-item" href="">-->
                                        <!--                                                        <i class="fa-solid fa-file-lines me-2"></i> A4-->
                                        <!--                                                    </a>-->
                                        <!--                                                </li>-->
                                        <!--                                            </ul>-->
                                        <!--                                        </div>-->
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