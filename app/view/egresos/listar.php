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
                <h5 class="font-weight-bold text-primary">EGRESOS REGISTRADOS</h5>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-3">
                <a class="btn btn-block btn-success btn-sm font-weight-bold" href="<?php echo _SERVER_;?>Egresos/agregar" ><i class="fa fa-plus"></i> AGREGAR NUEVO EGRESO</a>
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
                                    <th>Descripcion</th>
                                    <th>Monto</th>
                                    <th>Fecha del Registro</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $a = 1;
                                foreach ($egresos as $e){
                                    ?>
                                    <tr id="egresos<?= $e->id_egreso;?>">
                                        <td><?= $a;?></td>
                                        <td><?= $e->egreso_descripcion;?></td>
                                        <td><?= $e->egreso_monto;?></td>
                                        <td><?= $e->egreso_fecha_registro;?></td>
                                        <td><button id="btn-eliminar_egreso<?= $e->id_egreso;?>" class="btn btn-lg btn-danger btne" onclick="preguntar('¿Está seguro que desea eliminar este registro?','eliminar_egreso','Si','No',<?= $e->id_egreso;?>)"><i class="fa fa-close"></i> Eliminar Registro</button></td>
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