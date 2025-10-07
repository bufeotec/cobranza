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
    <!--<section class="content-header">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
    </section><br>-->

    <!-- Main content -->
    <section class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <hr><h2 class="concss">
                    <a href="http://localhost/fire"><i class="fa fa-fire"></i> INICIO</a> >
                    <i class="<?php echo $_SESSION['icono'];?>"></i> <?php echo $_SESSION['accion'];?>
                </h2><hr>
            </div>
        </div>
        <br><div class="row">
            <div class="col-lg-3">
                <input type="hidden" id="id_correlativo" value="<?php echo $correlativo->id_correlativo;?>">
                <label>Correlativo Boleta</label>
                <input type="text" class="form-control" id="correlativo_b" placeholder="Ingresar Correlativo Boleta..." value="<?php echo $correlativo->correlativo_b;?>" onkeypress="return valida(event)">
            </div>
            <div class="col-lg-3">
                <label>Correlativo Factura</label>
                <input type="text" class="form-control" id="correlativo_f" placeholder="Ingresar Correlativo Factura..." value="<?php echo $correlativo->correlativo_f;?>" onkeypress="return valida(event)">
            </div>
            <div class="col-lg-3">
                <label>Correlativo Guia de Entrada</label>
                <input type="text" class="form-control" id="correlativo_in" placeholder="Ingresar Correlativo Guia de Entrada..." value="<?php echo $correlativo->correlativo_in;?>" onkeypress="return valida(event)">
            </div>
            <div class="col-lg-3">
                <label>Correlativo Guia de Salida</label>
                <input type="text" class="form-control" id="correlativo_out" placeholder="Ingresar Correlativo Guia de Salida..." value="<?php echo $correlativo->correlativo_out;?>" onkeypress="return valida(event)">
            </div>
        </div>

        <br><div class="row">
            <div class="col-lg-3">
                <label>Correlativo Nota de Crédito</label>
                <input type="text" class="form-control" id="correlativo_nc" placeholder="Ingresar Correlativo Nota de Crédito..." value="<?php echo $correlativo->correlativo_nc;?>" onkeypress="return valida(event)">
            </div>
            <div class="col-lg-3">
                <label>Correlativo Nota de Débito</label>
                <input type="text" class="form-control" id="correlativo_nd" placeholder="Ingresar Correlativo Nota de Débito..." value="<?php echo $correlativo->correlativo_nd;?>" onkeypress="return valida(event)">
            </div>
            <div class="col-lg-3">
                <label>Correlativo Venta</label>
                <input type="text" class="form-control" id="correlativo_venta" placeholder="Ingresar Correlativo de Venta..." value="<?php echo $correlativo->correlativo_venta;?>" onkeypress="return valida(event)">
            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary" onclick="editar()" style="width: 100%; margin-top: 31px">Editar Correlativos</button>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
    <script src="<?php echo _SERVER_ . _JS_;?>correlativo.js"></script>