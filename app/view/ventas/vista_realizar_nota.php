<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 31/05/2021
 * Time: 01:35 p. m.
 */
?>

<!-- Modal para los servicios -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Listado de Servicios</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <table id="dataTable2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th style="width: 200px;">Servicio</th>
                            <th>Precio Normal</th>
                            <th>Precio Socio</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->id_servicio) ?></td>
                                <td><?= htmlspecialchars($p->servicio_nombre) ?></td>
                                <td>S/. <?= htmlspecialchars($p->servicio_precio_socio) ?></td>
                                <td>S/. <?= htmlspecialchars($p->servicio_precio_normal) ?></td>
                                <td>
                                    <button
                                            onclick="seleccionar_servicio_tablamodalservicio_vistacrearnota($(this));"
                                            type="button"
                                            class="btn btn-success btn-xs btn-elegir-servicio"
                                            data-dismiss="modal"
                                            data-service='<?= json_encode($p, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'>
                                        <i class="fa fa-check-circle"></i> Elegir
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--Modal para Clientes-->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Clientes Registrados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <a style="float: right;" href="<?php echo _SERVER_;?>Clientes/agregar" class="btn btn-success"><i class="fa fa-pencil"></i> Cliente Nuevo</a>
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead class="text-capitalize">
                        <tr>
                            <th>Nombre</th>
                            <th>DNI ó RUC </th>
                            <th>Dirección</th>
                            <th>Telefono o Celular</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $a = 1;
                        foreach ($clientes as $m){
                            ?>
                            <tr>
                                <td><?php echo $m->cliente_nombre.$m->cliente_razonsocial;?></td>
                                <td><?php echo $m->cliente_numero;?></td>
                                <td><?php echo $m->cliente_direccion;?></td>
                                <td><?php echo $m->cliente_telefono;?></td>
                                <td><button type="button" class="btn btn-xs btn-success btne" onclick="agregarPersona('<?php echo $m->cliente_nombre.$m->cliente_razonsocial;?>','<?php echo $m->cliente_numero;?>','<?php echo $m->cliente_direccion;?>','<?= $m->cliente_telefono;?>','<?= $m->id_tipodocumento;?>')" ><i class="fa fa-check-circle"></i> Elegir Cliente</button></td>
                            </tr>
                            <?php
                            $a++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <label>Tipo de Nota</label>
            <select id="tipo_venta" class="form-control" onchange = "selecttipoventa_(this.value)">
                <!--<option value="03">BOLETA</option>
                <option value="01">FACTURA</option>-->
                <option value= "">Seleccionar...</option>
                <!--<option value="03">BOLETA</option>
                <option value="01">FACTURA</option>-->
                <option value= "07">NOTA DE CREDITO</option>
                <option value= "08">NOTA DE DEBITO</option>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Serie</label>
            <select name="serie" id="serie" class="form-control" onchange="ConsultarCorrelativo()">
                <option value="">Seleccionar</option>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Numero</label>
            <input class="form-control" type="text" id="numero" readonly>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="tipo_moneda">Moneda</label><br>
                <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                    <option value="1">SOLES</option>
                    <option value="2">DOLARES</option>
                </select>
                <input type="hidden" id="id_venta" name="id_venta">
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-12" style="text-align: left">
            <h6 class="font-weight-bold" style="text-transform: uppercase">Datos del Cliente</h6>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="id_cliente" id="id_cliente" value="<?= $venta->id_cliente?>">
        <div class="col-lg-2">
            <label>Tipo de Pago</label>
            <select class="form-control" id="id_tipo_pago" name="id_tipo_pago">
                <?php
                foreach ($tipo_pago as $tp){
                    ?>
                    <option <?php echo ($tp->id_tipo_pago == 3) ? 'selected' : '';?> value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-lg-3">
            <label>Tipo Documento</label>
            <select  class="form-control" name="select_tipodocumento" id="select_tipodocumento">
                <option value="">Seleccionar...</option>
                <?php
                foreach ($tipos_documento as $td){
                    ($td->id_tipodocumento == $venta->id_tipodocumento)?$sele='selected':$sele='';
                    echo "<option value='".$td->id_tipodocumento."' ".$sele.">".$td->tipodocumento_identidad."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-lg-2" style="margin-top: 8px">
            <br>
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#basicModal" style="width: 100%"><i class="fa fa-search"></i> Buscar Cliente</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <label for="client_number">DNI ó RUC:</label>
            <input class="form-control" type="text" id="client_number" value="<?= $venta->cliente_numero?>" onchange="consultar_documento(this.value)">
        </div>
        <div class="col-lg-5">
            <label for="client_name">Nombre:</label>
            <input class="form-control" type="text" id="client_name" value="<?= (($venta->id_tipodocumento == 2)? $venta->cliente_nombre : $venta->cliente_razonsocial); ?>" placeholder="Ingrese Nombre...">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <label for="client_address">Direccion:</label>
            <textarea class="form-control" name="client_address" id="client_address"  rows="2" placeholder="Ingrese Dirección..."><?= $venta->cliente_direccion?></textarea>
            <!--<input class="form-control" type="text" id="client_address">-->
        </div>
        <div class="col-lg-2">
            <label for="client_address">Telefono:</label>
            <input class="form-control" type="text" id="client_telefono" placeholder="Ingrese telefono..." value="<?= $venta->cliente_telefono?>">
        </div>
    </div><hr>

    <div class="row" id="credito_debito">
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <label>Documento a modificar</label>
            <select name="" class="form-control" id="Tipo_documento_modificar" disabled>
                <option <?= (($venta->venta_tipo == '03')?$selec='selected':$selec=''); ?> value="03">BOLETA</option>
                <option <?= (($venta->venta_tipo == '01')?$selec='selected':$selec=''); ?> value="01">FACTURA</option>
            </select>
        </div>
        <div class="col-lg-2" id="serie_nota">
            <label>Serie</label>
            <input class="form-control" type="text" id="serie_modificar" value="<?= $venta->venta_serie;?>" readonly>
        </div>
        <div class="col-lg-2" id="numero_nota">
            <label>Numero</label>
            <input class="form-control" type="text" id="numero_modificar" value="<?= $venta->venta_correlativo;?>" readonly>
        </div>
        <div class="col-lg-3" id="nota_descripcion">
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <label for="product_barcode">Código o Nombre del Servicio:</label>
            <div class="autocomplete-container">
                <input class="form-control" type="text" id="product_search_input">
                <div id="product_suggestions" class="autocomplete-items"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <button style="width: 100%; margin-top: 25px" class="btn btn-success" type="button" data-toggle="modal" data-target="#largeModal"><i class="fa fa-search"></i> Buscar Servicio</button>
        </div>
    </div>

    <div id="tabla_productos"></div><br>

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <button type="button" id="btn_generarventa" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 1.5rem; width: 100%" onclick="preguntar('¿Está seguro que desea realizar esta Venta?','realizar_venta_vistacrearnota','Si','No')">
                <i class="fa fa-money"></i> GENERAR VENTA
            </button>
        </div>
    </div>

</div>

<style>
    .autocomplete-container {
        position: relative;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #f7f7f7; /* Color de fondo más claro para el contenedor */
        max-height: 200px;
        overflow-y: auto;
    }

    .autocomplete-items div,
    .autocomplete-items a {
        padding: 10px;
        cursor: pointer;
        background-color: #f7f7f7; /* El mismo color de fondo para los items */
        border-bottom: 1px solid #d4d4d4;
        color: #333;
        text-decoration: none;
        display: block;
    }

    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /* Estilo para el elemento de sugerencia seleccionado */
    .autocomplete-items div.active-suggestion {
        background-color: #aad6fb !important; /* Color de fondo azul (ejemplo de Bootstrap) */
        /*color: #fff !important; !* Color de texto blanco *!*/
    }
</style>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>notas.js"></script>
<script type="text/javascript">
    let productfull = "";
    let unid = "";

    $(document).ready(function(){
        $('#tabla_productos').load('<?php echo _SERVER_;?>Ventas/tabla_productos_html');
        $("#product_barcode").focus();
        $("#credito_debito").hide();
        $("#mostrar").hide();
        $("#detalle").hide();
        $("#detalle_").hide();
        $("#busqueda").hide();
        $("#general").hide();

        configurarEventosON_Autocompletado_BuscarserviciosInput_Notas();

        // Quitar fila de la tabla servicios
        $(document).on('click', '.tabla_servicio tbody .btn-quitar-servicio', function () {
            $(this).closest('tr').remove();
            recalcularTotal_tablaservicio_vistanotas();
        });

        $(document).on('input change', '.tabla_servicio tbody .inputsubtotal_socio_tabla', function (e) {
            const $inp = $(this);
            let v = parseFloat($inp.val());

            // validación mínima
            if (isNaN(v) || v < 0) v = 0;

            // al salir del campo, normaliza a 2 decimales
            if (e.type === 'change') $inp.val(v.toFixed(2));
            recalcularTotal_tablaservicio_vistanotas();
        });

        // Cuando cambia precio
        $(document).on('input change', '.tabla_servicio tbody .inputprecio-socio_tabla', function () {
            const $tr = $(this).closest('tr');
            actualizarSubtotalFila_tablaservicio_vistanotas($tr);
            recalcularTotal_tablaservicio_vistanotas();
        });

        $(document).on('input change', '.tabla_servicio tbody .inputcantidad-socio_tabla', function () {
            const $tr = $(this).closest('tr');
            actualizarSubtotalFila_tablaservicio_vistanotas($tr);
            recalcularTotal_tablaservicio_vistanotas();
        });


    });
</script>
