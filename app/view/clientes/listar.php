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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
        <a href="<?= _SERVER_;?>Clientes/vista_crear_clientes"><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Nuevo Cliente</button></a>

    </div>

    <!-- /.row (main row) -->
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->

            <div class="card shadow mb-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr style="text-align: center;"t>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>NÚMERO DE DOCUMENTO</th>
                                <th>CORREO</th>
                                <th>DIRECCIÓN</th>
                                <th>TELÉFONO</th>
                                <th>OPCIONES</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($clientes as $c){
                                if($c->id_tipodocumento != "4"){
                                    $nombre = $c->cliente_nombre;
                                }else{
                                    $nombre = $c->cliente_razonsocial;
                                }
                                ?>
                                <tr id="cliente<?= $c->id_cliente;?>">
                                    <td><?= $a;?></td>
                                    <td><?= $nombre;?></td>
                                    <td><?= $c->cliente_numero;?></td>
                                    <td><?= $c->cliente_correo;?></td>
                                    <td><?= $c->cliente_direccion;?></td>
                                    <td><?= $c->cliente_telefono;?></td>
                                    <td>
                                        <?php
                                        if($c->id_cliente != 1){
                                            ?>
                                            <a href="<?= _SERVER_ ?>Clientes/vista_editar_clientes/<?= $c->id_cliente ?>" class="btn btn-sm btn-primary btne" title="EDITAR"><i class="fa fa-pencil"></i></a>

                                            <?php
                                            $validar = $this->clientes->validar($c->id_cliente);
                                            (empty($validar))?$resultado=true:$resultado=false;
                                            if($resultado){
                                                ?>
                                                <button id="btn-eliminar_cliente<?= $c->id_cliente;?>" class="btn btn-sm btn-danger btne" onclick="preguntar('¿Está seguro que desea Eliminar este Cliente?','eliminarcliente','Si','No',<?= $c->id_cliente;?>)" title="ELIMINAR"><i class="fa fa-trash"></i></button>
                                                <?php
                                            }else{
                                                ?>
                                                <button id="btn-eliminar_cliente<?= $c->id_cliente;?>" class="btn btn-sm btn-danger btne" onclick="preguntar('¿Está seguro que desea Deshabilitar este Cliente?','cambiar_estado','Si','No',<?= $c->id_cliente;?>)" title="DESHABILITAR"><i class="fa fa-trash"></i></button>
                                                <?php
                                            }
                                        }
                                        ?>
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

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>clientes.js"></script>
