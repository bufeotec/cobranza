<?php
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?>
        </h1>
        <div class="btn-group">
            <a href="<?= _SERVER_;?>Ventas/vista_ver_ventas" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fa fa-arrow-left"></i> Volver
            </a>
            <a href="<?= _SERVER_;?>Ventas/vista_realizar_venta" class="btn btn-success btn-sm shadow-sm">
                <i class="fa fa-plus fa-sm text-white-50"></i> Nueva Venta
            </a>
            <a  target="_blank" href="<?= _SERVER_ . 'Ventas/imprimir_ticket_pdf_A4/' .$id?>" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa fa-print"></i> Ver pdf
            </a>
<!--            <button class="btn btn-info btn-sm shadow-sm">-->
<!--                <i class="fa fa-print"></i> ver PDF-->
<!--            </button>-->
        </div>
    </div>

    <!-- Detalle de Venta -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Datos de la Venta -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-black-50">
                    <h6 class="m-0 font-weight-bold">Información de la Venta</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>N° Venta: </strong> <?= $venta->venta_correlativo ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha:</strong> <?= htmlspecialchars(date('Y-m-d', strtotime($venta->venta_fecha))) ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Cliente:</strong> <?= $venta->cliente_nombre == '' ? $venta->cliente_razonsocial : $venta->cliente_nombre ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>Documento:</strong> <?= $venta->serie_modificar .'-' . $venta->correlativo_modificar  ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Vendedor:</strong> Admin
                        </div>
                        <div class="col-md-4">
                            <strong>Estado:</strong> <span class="badge badge-success">Pagado</span>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>Respuesta Sunat:</strong>
                        </div>
                        <div class="col-md-12">
                            <?= $venta->venta_respuesta_sunat?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $a = 1;
                foreach ($detalle_venta as $v) {
                    ?>
                    <tr>
                        <td><?= $a ?></td>
                        <td><?= $v->venta_detalle_descripcion ?></td>
                        <td><?= $v->venta_detalle_cantidad ?></td>
                        <td>S/. <?= htmlspecialchars($v->venta_detalle_precio_unitario) ?></td>
                        <td>S/. <?= htmlspecialchars($v->venta_detalle_valor_total) ?></td>
                    </tr>
                    <?php
                    $a++;
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Resumen -->
        <div class="row justify-content-end">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <strong>S/. <?=  htmlspecialchars($venta->venta_totalexonerada)?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>IGV (18%):</span>
                        <strong>S/. <?=  htmlspecialchars($venta->venta_totaligv)?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span>Total:</span>
                        <strong>S/. <?=  htmlspecialchars($venta->venta_total)?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
