<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>

<!-- Modal vista previa PDF -->
<div class="modal fade" id="idmodalpdfdemo" tabindex="-1" aria-labelledby="idmodalpdfdemoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vista Previa Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" style="height:400px; position: relative;">
                <!-- Loader -->
                <div id="loader" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
                <!-- Iframe oculto al inicio -->
                <iframe id="iframe_preview" style="width:100%; height:100%; border:none; display:none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_generarventa" class="btn btn-primary" onclick="preguntar('¿Está seguro que desea realizar esta Venta?','realizar_venta','Si','No')">
                    <i class="fa fa-money"></i> GENERAR VENTA
                </button>
<!--                <button type="button" class="btn btn-primary" id="btn_generarventa" onclick="realizar_venta()">-->
<!--                    <i class="fa fa-money"></i> GENERAR VENTA-->
<!--                </button>-->
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
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
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
                                <td>
                                    <button type="button" class="btn btn-xs btn-success btne" onclick="agregarPersona(
                                        '<?= $m->id_cliente;?>',
                                        '<?php echo $m->cliente_nombre.$m->cliente_razonsocial;?>',
                                        '<?php echo $m->cliente_numero;?>',
                                        '<?php echo $m->cliente_direccion;?>',
                                        '<?= $m->cliente_telefono;?>',
                                        '<?= $m->id_tipodocumento;?>')"
                                        ><i class="fa fa-check-circle"></i> Elegir Cliente
                                    </button>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

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
                                                onclick="seleccionar_servicio_tablamodalservicio($(this));"
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

<!-- Modal VENTA A CREDITO -->
<div class="modal fade" id="idmodalcredito" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title_credito">Pago con Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">Cuota</label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Importe</label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Fecha Cuota</label>
                        </div>
                    </div>
                </div>


                <div class="container-fluid" id="cuotas-container">
                    <!-- Las cuotas se generarán dinámicamente aquí -->
                </div>

                <!-- Sección de totales -->
                <div class="total-section">
                    <div class="row">
                        <div class="col-md-6" >
                            <strong style="display: none">Total de Cuotas: <span id="total-cuotas">0</span></strong>
                        </div>
                        <div class="col-md-6">
                            <strong>Suma Total: S/ <span id="suma-total">0.00</span></strong>
                        </div>
                    </div>
                </div>

                <!-- Mensajes de validación generales -->
                <div id="validation-messages" class="mt-3"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <!-- Botón pegado a la izquierda -->
                <button type="button" class="btn btn-secondary" id="btn-agregar-cuota" onclick="agregarCuota();">
                    <i class="fa fa-plus"></i> Más Cuotas
                </button>

                <!-- Botones a la derecha -->
                <div>
                    <button style="display: none" type="button" class="btn btn-outline-info me-2" id="btn-obtener-datos">
                        <i class="fa fa-eye"></i> Ver Datos
                    </button>
                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-guardar" onclick="guardar_cuotas();">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar los datos -->
<div class="modal fade" id="modal-datos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos de las Cuotas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="datos-json" class="bg-light p-3 rounded"></pre>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-2">
            <label>Tipo de Comprobante</label>
            <select id="tipo_venta" class="form-control" onchange = "Consultar_serie()">
                <?php foreach ($tipo_comprobante as $tc): ?>
                    <option <?php echo ($tc->tipocomp == '01') ? 'selected' : '';?> value="<?php echo $tc->tipocomp;?>"><?php echo $tc->nombrecomp;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Serie</label>
            <select name="serie" id="serie" class="form-control" onchange="ConsultarCorrelativo()">
                <option value="">Seleccionar</option>
            </select>
        </div>
        <div class="col-lg-2">
            <label>Correlativo</label>
            <input class="form-control" type="text" id="numero" readonly>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="tipo_moneda">Moneda</label><br>
                <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                    <option value="1">SOLES</option>
                    <option value="2">DOLARES</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <label>Forma de Pago</label>
            <select class="form-control" id="idselectformapago" name="idselectformapago">
                <option value="1" selected>CONTADO</option>
                <option value="2">CRÉDITO</option>
            </select>
        </div>
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
    </div>

<!--    datos del cliente-->
    <hr>
    <div class="row">
        <div class="col-lg-12" style="text-align: left">
            <h6 class="font-weight-bold" style="text-transform: uppercase">Datos del Cliente</h6>
        </div>
    </div>

    <div class="row">
        <input type="hidden" id="idinput_idclienteventa" value="0">
        <div class="col-lg-3">
            <label>Tipo Documento</label>
            <select  class="form-control" name="select_tipodocumento" id="select_tipodocumento" onchange="seleccionar_tipodocumento()">
                <option value="">Seleccionar...</option>
                <?php
                foreach ($tipos_documento as $td){
                    echo "<option value='".$td->id_tipodocumento."'>".$td->tipodocumento_abreviado."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-lg-3">
            <label for="client_number">Nro Documento:</label>
            <input class="form-control" type="text" id="client_number" value="" autofocus onchange="consultar_documento(this.value)">
        </div>
        <div class="col-lg-3">
            <br>
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#basicModal" style="width: 100%"><i class="fa fa-search"></i> Buscar Cliente</button>
        </div>
        <div class="col-lg-3">
            <div class="form-check" style="margin-top: 20px;">
                <input class="form-check-input" type="checkbox" id="chkCobranza" >
                <label class="form-check-label" for="chkCobranza">
                    Pasar a Cobranza
                </label>
            </div>
        </div>

    </div>

    <div class="row" style="margin-top: 10px">
        <div class="col-lg-5">
            <label for="client_name">Nombre / Razón social:</label>
            <input class="form-control" type="text" name="client_name" id="client_name" value="PÚBLICO EN GENERAL">
        </div>
        <div class="col-lg-7">
            <label for="client_address">Domicilio Fiscal:</label>
            <textarea class="form-control" name="client_address" id="client_address"  rows="2" placeholder="Ingrese Dirección..."></textarea>
            <!--<input class="form-control" type="text" id="client_address">-->
        </div>
        <div class="col-lg-4">
            <label for="client_address">Celular:</label>
            <input class="form-control" type="text" id="client_telefono">
        </div>
        <div class="col-lg-8">
            <label for="client_address">Observaciones:</label>
            <textarea class="form-control" name="venta_nota_dato" id="venta_nota_dato"  rows="2"></textarea>
        </div>
    </div>

    <!--    datos del servicio-->
    <hr>
    <div class="row">
        <div class="col-lg-12" style="text-align: left">
            <h6 class="font-weight-bold" style="text-transform: uppercase">Datos del Servicio</h6>
        </div>
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


    <div id="tabla_productos"></div>

    <br>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
<!--            <button type="button" id="btn_generarventa" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 1.5rem; width: 100%; margin-top: 5px;" onclick="preguntar('¿Está seguro que desea realizar esta Venta?','realizar_venta','Si','No')">-->
<!--                <i class="fa fa-money"></i> GENERAR VENTA-->
<!--            </button>-->
            <button
                onclick="vista_previa_venta()"
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#idmodalweb">
                GENERAR VENTA
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

<!--EndQ of Main Content-->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>ventas.js?v=<?= time();?>"></script>
<script type="text/javascript">
    let productfull = "";
    let unid = "";

    $(document).ready(function() {
        $('#tabla_productos').load('<?php echo _SERVER_;?>Ventas/tabla_productos_html');
        Consultar_serie();
        configurarEventosON_Autocompletado_BuscarserviciosInput();

        // Quitar fila
        $(document).on('click', '.btn-quitar-servicio', function () {
            $(this).closest('tr').remove();
            recalcularTotal();
        });

        $(document).on('input change', '.tabla_servicio tbody .inputsubtotal_socio_tabla', function (e) {
            const $inp = $(this);
            let v = parseFloat($inp.val());

            // validación mínima
            if (isNaN(v) || v < 0) v = 0;

            // al salir del campo, normaliza a 2 decimales
            if (e.type === 'change') $inp.val(v.toFixed(2));
            recalcularTotal();
        });

        // Cuando cambia precio
        $(document).on('input change', '.tabla_servicio tbody .inputprecio-socio_tabla', function () {
            const $tr = $(this).closest('tr');
            actualizarSubtotalFila_tablaservicio($tr);
            recalcularTotal();
        });

        $(document).on('input change', '.tabla_servicio tbody .inputcantidad-socio_tabla', function () {
            const $tr = $(this).closest('tr');
            actualizarSubtotalFila_tablaservicio($tr);
            recalcularTotal();
        });

        $("#idselectformapago").on("change", function(){
            cuotaCounter = 0;
            cuotasData = [];
            MAX_IMPORTE = $("#idlabeltotalventa").text().replace("S/.", "").trim();

            if(MAX_IMPORTE > 0){
                $("#modal_title_credito").text(`Pago a Crédito de un valor de S/. ${MAX_IMPORTE}`);
                $("#cuotas-container").empty();
                $("#validation-messages").empty();
                cuotalimpiarbool = false;
                agregarCuota();
                actualizarTotales();
                if($(this).val() == "2"){
                    $("#idmodalcredito").modal("show"); // abrir modal
                }
            }else{
                $("#idselectformapago").val("1");
                respuesta("Porfavor Agregue un servicio al carrito", "error");
            }

        });

        // Botón para ver datos (para demostración)
        $("#btn-obtener-datos").on("click", function() {
            const datos = obtenerDatosCuotas();
            $("#datos-json").text(JSON.stringify(datos, null, 2));
            $("#modal-datos").modal("show");
        });

        // Limpiar mensajes cuando se cierra el modal
        $("#idmodalcredito").on("hidden.bs.modal", function() {
            if (cuotalimpiarbool) {
                console.log("Modal cerrado después de guardar exitosamente");
                $("#idselectformapago").val("2");
            } else {
                console.log("Modal cancelado - limpiando datos");
                $("#idselectformapago").val("1");
                cuotaCounter = 0;
                $("#cuotas-container").empty();
            }

            $("#validation-messages").empty();
        });

        // Validación de fecha en inputs
        $("#cuotas-container").on("change", ".fecha-input", function() {
            const $input = $(this);
            const cuotaId = $input.data("cuota");
            const fechaSeleccionada = new Date($input.val() + "T00:00:00"); // normalizamos
            const fechaMinima = new Date(obtenerFechaMinima() + "T00:00:00");

            const $errorDiv = $(`#error-fecha-${cuotaId}`);

            $input.removeClass("input-error");
            $errorDiv.empty();

            if (fechaSeleccionada < fechaMinima) {
                $input.addClass("input-error");
                $errorDiv.text(`La fecha debe ser posterior a ${obtenerFechaMinima()}.`);
            }

            validarFormularioCuota();
        });


        // Validación en tiempo real del importe
        $("#cuotas-container").on("input", ".importe-input", function() {
            const $input = $(this);
            const cuotaId = $input.data("cuota");
            const valor = parseFloat($input.val()) || 0;
            const $errorDiv = $(`#error-importe-${cuotaId}`);

            // Limpiar clases de error
            $input.removeClass("input-error");
            $errorDiv.empty();

            // Validar rango
            if (valor > MAX_IMPORTE) {
                $input.addClass("input-error");
                $errorDiv.text(`El importe no debe superar a los S/ ${MAX_IMPORTE}`);
                $input.val(""); // Limpiar el input automáticamente
                actualizarTotales();
                return;
            }

            if (valor < 0.01 && $input.val() !== "") {
                $input.addClass("input-error");
                $errorDiv.text("El importe debe ser mayor a S/ 0.00");
            }

            // Calcular suma total incluyendo este valor
            const sumaTotal = calcularSumaTotal();

            // Si la suma excede el límite, limpiar este input
            if (sumaTotal > MAX_IMPORTE) {
                $input.addClass("input-error");
                $errorDiv.text(`La suma total excedería el límite de S/. ${MAX_IMPORTE}`);
                $input.val(""); // Limpiar automáticamente
            }

            actualizarTotales();
            validarFormularioCuota();
        });

        // Eliminar cuota (delegación de eventos)
        $("#cuotas-container").on("click", ".btn-eliminar", function() {
            const cuotaId = $(this).data("cuota");

            // No permitir eliminar si es la única cuota
            if ($("#cuotas-container .cuota-row").length <= 1) {
                mostrarMensajeGeneral("Debe mantener al menos una cuota.", "error");
                return;
            }

            $(this).closest(".cuota-row").remove();
            renumerarCuotas();
            actualizarTotales();
            validarFormularioCuota();
        });
    });

    // function selecttipoventa_(valor){
    //     selecttipoventa(valor);
    //     if (valor == "07" || valor == "08"){
    //         $('#credito_debito').show();
    //
    //         if(valor == "07"){
    //             $('#notaCredito').show();
    //             $('#notaDebito').hide();
    //         }else{
    //             $('#notaCredito').hide();
    //             $('#notaDebito').show();
    //         }
    //         var tipo_comprobante =  valor;
    //         $.ajax({
    //             type: "POST",
    //             url: urlweb + "api/Ventas/tipo_nota_descripcion",
    //             data: "tipo_comprobante="+tipo_comprobante,
    //             dataType: 'json',
    //             success:function (r) {
    //                 $("#nota_descripcion").html(r);
    //             }
    //         });
    //     } else{
    //         $('#credito_debito').hide();
    //     }
    // }
    //
    // function selecttipoventa(valor){
    //     console.log("selecttipoventa consulta 1");
    //     Consultar_serie();
    //     var tipo_comprobante =  valor;
    //     $.ajax({
    //         type: "POST",
    //         url: urlweb + "api/Ventas/tipo_nota_descripcion",
    //         data: "tipo_comprobante="+tipo_comprobante,
    //         dataType: 'json',
    //         success:function (r) {
    //             $("#nota_descripcion").html(r);
    //         }
    //     });
    // }

    function agregarPersona(idcliente, nombre, numero, direccion, telefono, id_tipodocumento) {
        $("#client_number").val(numero);
        $("#client_name").val(nombre);
        $("#client_address").val(direccion);
        $("#client_telefono").val(telefono);
        $("#select_tipodocumento").val(id_tipodocumento);
        $("#idinput_idclienteventa").val(idcliente);
        respuesta('El cliente se agregó correctamente!','success');

    }

    function Consultar_serie(){
        //var tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        var tipo_venta =  $("#tipo_venta").val();
        if(tipo_venta == "01"){
            $("#select_tipodocumento").val('4');
            $("#cliente_numero").val('');
            $("#cliente_nombre").val('');
        }else{
            $("#select_tipodocumento").val('2');
            $("#cliente_numero").val('11111111');
            $("#cliente_nombre").val('ANONIMO');
        }
        var concepto = "LISTAR_SERIE";
        var cadena = "tipo_venta=" + tipo_venta +
            "&concepto=" + concepto;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                var series = "";
                //var series = "<option value='' selected>Seleccione</option>";
                for (var i=0; i<r.serie.length; i++){
                    series += "<option value='"+r.serie[i].id_serie+"'>"+r.serie[i].serie+"</option>"
                }
                $("#serie").html(series);
                ConsultarCorrelativo();
            }

        });
    }

    function ConsultarCorrelativo(){
        var id_serie =  $("#serie").val();
        var concepto = "LISTAR_NUMERO";
        var cadena = "id_serie=" + id_serie +
            "&concepto=" + concepto;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/consultar_serie",
            data: cadena,
            dataType: 'json',
            success:function (r) {
                $("#numero").val(r.correlativo);
            }

        });
    }

    function seleccionar_tipodocumento(){
        var tipo_documento = $('#select_tipodocumento').val();
        if(tipo_documento == "4"){
            $("#tipo_venta").val('01');
        }else{
            $("#tipo_venta").val('03');
        }
        Consultar_serie()
    }

    function configurarEventosON_Autocompletado_BuscarserviciosInput() {
        // Maneja lo que sucede cada vez que escribes en el input
        $inputBuscador.on('input', function() {
            const textoBuscado = $(this).val();
            clearTimeout(idTemporizador);
            indiceSeleccionado = -1; // Reinicia la selección

            if (textoBuscado.length === 0) {
                $sugerenciasContenedor.empty().hide();
                return;
            }

            // Espera un poco para no enviar una petición por cada letra
            idTemporizador = setTimeout(() => {
                buscarServicios(textoBuscado);
            }, 300);
        });

        // Maneja las teclas de navegación (flechas y Enter)
        $inputBuscador.on('keydown', manejarTeclas);

        // Oculta las sugerencias si haces clic en otro lado de la página
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.autocomplete-container').length) {
                $sugerenciasContenedor.empty().hide();
            }
        });
    }
</script>
