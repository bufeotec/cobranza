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

    <section class="container-fluid">
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4" style="text-align: center;">
                <h5 class="font-weight-bold text-primary">COMPROBANTES REGISTRADOS</h5>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-3">
                <a class="btn btn-success" href="<?php echo _SERVER_;?>Egresos/agregar_facturas" ><i class="fa fa-plus"></i> AGREGAR COMPROBANTE</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista de Egresos Registrados</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo Comprobante</th>
                                    <th>Serie y Correlativo</th>
                                    <th>Concepto</th>
                                    <th>RUC proveedor</th>
                                    <th>Tipo de Pago</th>
                                    <th>Fecha de Emisión</th>
                                    <th>Fecha de Registro</th>
                                    <th>Ver Archivo</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $a = 1;
                                foreach ($comprobantes as $e){
                                    ?>
                                    <tr id="comprobantes<?= $e->id_comprobante;?>">
                                        <td><?= $a;?></td>
                                        <td><?= $e->comprobante_tipo;?></td>
                                        <td><?= $e->comprobante_serie;?>-<?= $e->comprobante_correlativo;?></td>
                                        <td><?= $e->comprobante_concepto?></td>
                                        <td><?= $e->comprobante_ruc_proveedor;?></td>
                                        <td><?= $e->tipo_pago_nombre;?></td>
                                        <td><?= $e->comprobante_fecha_emision;?></td>
                                        <td><?= $e->comprobante_fecha_registro;?></td>
                                        <td><a href="<?= _SERVER_ . $e->comprobante_archivo?>" target="_blank"> Ver</a></td>
                                        <td>
                                            <a id="btn-eliminar_comprobante<?= $e->id_comprobante;?>" class="btn btn-danger" onclick="preguntar('¿Esta Seguro que desea Eliminar este comprobante?','eliminar_comprobante','SÍ','NO',<?= $e->id_comprobante?>)" style="color: white" data-toggle='tooltip' title='Eliminar'><i class='fa fa-trash-o eliminar margen'></i></a>
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


    </section>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>egresos.js"></script>