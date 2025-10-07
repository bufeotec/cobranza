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

    <!-- Main content -->
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="text-align: center">
                <h5 class="font-weight-bold">AGREGAR EGRESO</h5>
            </div>
        </div><br>

        <div class="row">
            <!-- left column -->
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <label >Descripción:</label>
                <textarea class="form-control" cols="30" rows="2" id="egreso_descripcion" name="egreso_descripcion" placeholder="Ingresar Descripción..."></textarea>
            </div>
            <div class="col-md-3">
                <label >Monto del Egreso (Monto en S/.)</label>
                <input type="text" class="form-control" id="egreso_monto" name="egreso_monto" placeholder="Ingresar Monto" onkeyup="return validar_numeros(this.id)">
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <button id="btn-agregar-egreso" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.5rem" onclick="agregar_egreso()"><i class="fa fa-save"></i> Agregar Egreso</button>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>egresos.js"></script>