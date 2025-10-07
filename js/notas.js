const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

// Variables globales para el estado del buscador de servicios y sugerencas
let idTemporizador = null;
let indiceSeleccionado = -1;
const $inputBuscador = $('#product_search_input');
const $sugerenciasContenedor = $('#product_suggestions');
//*

function realizar_venta_vistacrearnota(){
    let message = "";
    let botonventa = 'btn_generarventa';
    let tipo_venta = $("#tipo_venta").val();
    let serie = $("#serie").find(":selected").text();
    let numero = $("#numero").val();
    let tipo_moneda = $("#tipo_moneda").val();
    let id_tipo_pago = $("#id_tipo_pago").val();
    let select_tipodocumento = $("#select_tipodocumento").val();
    let idselectformapago = $("#idselectformapago").val();
    let client_number = $("#client_number").val();
    let client_name = $("#client_name").val();
    let client_direccion = $("#client_address").val();
    let idcliente = $("#id_cliente").val();
    let ventatotal = $("#idlabeltotalventa").text();
    MAX_IMPORTE = ventatotal;
    let ventatotalexonerada = $("#idlabeltotalexonerada").text();


    let Tipo_documento_modificar = "";
    let serie_modificar = "";
    let numero_modificar = "";
    let notatipo_descripcion = "";
    let valor = false;
    let valor_ = true;

    if(tipo_venta === ""){
        respuesta("Seleccione un el Tipo de Nota", "error");
        return;;
    }

    if (tipo_venta === "07" || tipo_venta === "08"){
        Tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        serie_modificar = $('#serie_modificar').val();
        numero_modificar = $('#numero_modificar').val();
        notatipo_descripcion = $('#notatipo_descripcion').val();
    }

    let datosventaactual = [];
    $(".tabla_servicio tbody tr").each(function () {
        const $tr = $(this);
        const obj = {
            id_servicio: $tr.data("id"),
            venta_detalle_nombre_servicio: $tr.find(".inputnombre-socio_tabla").val(),
            venta_detalle_cantidad_servicio: $tr.find(".inputcantidad-socio_tabla").val(),
            venta_detalle_precio_unitario: $tr.find(".inputprecio-socio_tabla").val(),
            venta_detalle_valor_total: parseFloat($tr.find(".inputsubtotal_socio_tabla").val()) || 0
        };

        // if(tipo_venta === "07" && notatipo_descripcion === "01"){
        //
        // }

        datosventaactual.push(obj);
    });

    if(datosventaactual.length <= 0){
        respuesta("El carrito esta vacio, agregue un servicio", 'error');
        return;
    }

    const ventas = {
        id_cliente : idcliente,
        id_tipo_pago : id_tipo_pago,
        venta_tipo_moneda : tipo_moneda,
        venta_tipo_envio : tipo_venta,
        venta_tipo : tipo_venta,
        venta_serie : serie,
        venta_correlativo : numero,
        producto_venta_des_global : 1,
        // producto_venta_totalgratuita : "",
        venta_totalexonerada : ventatotalexonerada.replace("S/.", "").trim(),
        producto_venta_totalinafecta : 1,
        // producto_venta_totalgravada : "",
        producto_venta_totaligv : 1,
        // producto_venta_des_total : "",
        // producto_venta_icbper : "",
        venta_total : ventatotal.replace("S/.", "").trim(),
        // producto_venta_pago : "",
        // producto_venta_vuelto : "",
        venta_fecha : fechaLocal,
        tipo_documento_modificar : Tipo_documento_modificar,
        serie_modificar : serie_modificar,
        correlativo_modificar : numero_modificar,
        venta_codigo_motivo_nota : notatipo_descripcion,
        // venta_nota_dato : "",
        detalle_venta : datosventaactual,
        venta_forma_pago: idselectformapago,
        client_name: client_name,
        client_direccion: client_direccion,
        client_number: client_number
    }

    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/guardar_venta",
        data: ventas,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(botonventa, 'cobrando...', true);
        },
        success: function (r) {
            cambiar_estado_boton(botonventa, "<i class=\"fa fa-money\"></i> GENERAR VENTA", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Venta realizada correctamente!', 'success');
                    location.reload();
                    // location.href = urlweb + 'Ventas/ver_venta/' + r.result.idventa;
                    break;
                case 2:
                    respuesta('Error al generar Venta', 'error');
                    break;
                case 5:
                    respuesta('Error al generar Venta, revisar Cliente', 'error');
                    break;
                default:
                    respuesta(`¡${r.result.message}!`, 'error');
                    break;
            }
        }
    });
}

function selecttipoventa_(valor){
    selecttipoventa(valor);
    if (valor == "07" || valor == "08"){
        $('#credito_debito').show();

        if(valor == "07"){
            $('#notaCredito').show();
            $('#notaDebito').hide();
        }else{
            $('#notaCredito').hide();
            $('#notaDebito').show();
        }
        var tipo_comprobante =  valor;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/tipo_nota_descripcion",
            data: "tipo_comprobante="+tipo_comprobante,
            dataType: 'json',
            success:function (r) {
                $("#nota_descripcion").html(r);
            }
        });
    } else{
        $('#credito_debito').hide();
    }
}

function calcular_vuelto(valor){
    var monto_cliente = valor;
    var monto_total = $('#montototal').val();
    var vuelto_sin_ = monto_cliente - monto_total;
    var vuelto_sin = vuelto_sin_.toFixed(2);
    $('#pago_con').html(monto_cliente);
    $('#pago_con_').val(monto_cliente);
    $('#vuelto').html(vuelto_sin);
    $('#vuelto_').val(vuelto_sin);
}

function recargar_productos() {
    $('#tabla_productos').load('<?php echo _SERVER_;?>Ventas/tabla_productos');
}

function agregarPersona(nombre, numero, direccion, telefono, id_tipodocumento) {
    $("#client_number").val(numero);
    $("#client_name").val(nombre);
    $("#client_address").val(direccion);
    $("#client_telefono").val(telefono);
    $("#select_tipodocumento").val(id_tipodocumento);
    respuesta('El cliente se agregó correctamente!','success');

}

function onchangeundZ() {
    var cant = $("#product_cantb").val();
    var precio = $("#product_priceb").val();
    var subtotal = cant * precio;
    subtotal.toFixed(2);
    $("#product_totalb").val(subtotal);
}

function onchangeundpriceZ() {
    var cant = $("#product_cantb").val();
    var precio = $("#product_priceb").val();
    var subtotal = cant * precio;
    subtotal.toFixed(2);
    subtotal = parseFloat(subtotal);
    $("#product_totalb").val(subtotal);
}

function onchangetotalpriceZ() {
    var subtotal = $("#product_totalb").val();
    var cant = $("#product_cantb").val();
    var precio = subtotal / cant;
    precio.toFixed(2);
    $("#product_priceb").val(precio);
}

function buscar_producto_barcode() {
    var valor = "correcto";
    var product_barcode = $('#product_barcode').val();
    if(product_barcode == ""){
        alertify.error('El campo Código de Barra está vacío');
        $('#product_barcode').css('border','solid red');
        valor = "incorrecto";
    } else {
        $('#product_barcode').css('border','');
    }

    if (valor == "correcto"){
        var cadena = "product_barcode=" + product_barcode;
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ventas/search_by_barcode",
            data: cadena,
            success:function (r) {
                if(r=="2"){
                    alertify.error("ERROR O PRODUCTO NO REGISTRADO");
                    $('#product_nameb').val('');
                    $('#id_productforsaleb').val('');
                    $('#product_stockb').val('');
                    $('#product_priceb').val('');
                    $('#product_totalb').val('');
                    $('#codigo_afectacion').val('');
                    $('#product_cantb').val(1);
                    productfull = "";
                    unid = "";
                } else {
                    var productoinfo = r.split('|');
                    var fullproductname = productoinfo[0];
                    productfull = fullproductname;
                    unid =  productoinfo[1];
                    $('#product_nameb').val(fullproductname);
                    $('#id_productforsaleb').val(productoinfo[3]);
                    $('#product_stockb').val(productoinfo[2]);
                    $('#product_priceb').val(productoinfo[5]);
                    $('#product_totalb').val(productoinfo[5]);
                    $('#product_cantb').val(1);
                    $('#codigo_afectacion').val(productoinfo[7]);
                    $("#busqueda").show();
                    $("#detalle").show();
                    $("#detalle_").show();
                    $("#general").show();
                    //$("#mostrar").show();
                    respuesta('PRODUCTO ENCONTRADO');
                }
            }
        });
    }
}

function agregarProductoZ() {
    var cod = $('#id_productforsaleb').val();
    var cant = $("#product_cantb").val() * 1;
    var precio = $("#product_priceb").val() * 1;
    var stock = $("#product_stockb").val() * 1;
    var tipo_igv = $("#codigo_afectacion").val();
    var cadena = "codigo=" + cod +
        "&producto=" + productfull +
        "&unids=" + unid +
        "&precio=" + precio +
        "&cantidad=" + cant +
        "&tipo_igv=" + tipo_igv;

    if(stock >= cant){
        $.ajax({
            type:"POST",
            url: urlweb + "api/Ventas/addproduct",
            data : cadena,
            success:function (r) {
                switch (r) {
                    case "1":
                        respuesta('Producto Agregado');
                        $('#tabla_productos').load(urlweb + 'Ventas/tabla_productos');
                        $('#product_nameb').val('');
                        $('#id_productforsaleb').val('');
                        $('#product_stockb').val('');
                        $('#product_priceb').val('');
                        $('#product_totalb').val('');
                        $('#product_barcode').val('');
                        $('#codigo_afectacion').val('');
                        productfull = "";
                        unid = "";
                        $("#product_barcode").focus();
                        $("#general").hide();
                        break;
                    case "2":
                        respuesta('Hubo Un Error','error');
                        break;
                    case "3":
                        respuesta('El Producto YA ESTA AGREGADO','error');
                        break;
                    default:
                        respuesta('Hubo Un Error','error');
                        break;
                }
            }
        });
    } else {
        respuesta('NO HAY STOCK DISPONIBLE','error');
    }

}

function selecttipoventa(valor){
    Consultar_serie();
    var tipo_comprobante =  valor;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/tipo_nota_descripcion",
        data: "tipo_comprobante="+tipo_comprobante,
        dataType: 'json',
        success:function (r) {
            $("#nota_descripcion").html(r);
        }
    });
}

function Consultar_serie(){
    var tipo_documento_modificar = $('#Tipo_documento_modificar').val();
    var tipo_venta =  $("#tipo_venta").val();
    var concepto = "LISTAR_SERIE";
    var cadena = "tipo_venta=" + tipo_venta +
        "&concepto=" + concepto +
        "&tipo_documento_modificar=" + tipo_documento_modificar;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/consultar_serie_nota",
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

function consultar_documento(valor){
    var tipo_doc = $('#select_tipodocumento').val();
    if(tipo_doc == "2"){
        ObtenerDatosDni(valor);
    }else if(tipo_doc == "4"){
        ObtenerDatosRuc(valor);
    }
}

function ObtenerDatosDni(valor){
    var numero_dni =  valor;

    $.ajax({
        type: "POST",
        url: urlweb + "api/Clientes/obtener_datos_x_dni",
        data: "numero_dni="+numero_dni,
        dataType: 'json',
        success:function (r) {
            $("#client_name").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
        }
    });
}

function ObtenerDatosRuc(valor){
    var numero_ruc =  valor;

    $.ajax({
        type: "POST",
        url: urlweb + "api/Clientes/obtener_datos_x_ruc",
        data: "numero_ruc="+numero_ruc,
        dataType: 'json',
        success:function (r) {
            $("#client_name").val(r.result.razon_social);
        }
    });
}

//Logica para el BUscador de servicios y sugerencias
function manejarTeclas_inputbusquedaservicio_notas(e) {
    const $items = $sugerenciasContenedor.find('div');
    const totalItems = $items.length;

    if (totalItems === 0 || $items.text() === 'No se encontraron servicios') return;

    // Flecha Abajo
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        indiceSeleccionado = (indiceSeleccionado + 1) % totalItems;
        actualizarSeleccion_vistacrearnotas($items);
    }
    // Flecha Arriba
    else if (e.key === 'ArrowUp') {
        e.preventDefault();
        indiceSeleccionado = (indiceSeleccionado - 1 + totalItems) % totalItems;
        actualizarSeleccion_vistacrearnotas($items);
    }
    // Tecla Enter
    else if (e.key === 'Enter') {
        e.preventDefault();
        if (indiceSeleccionado !== -1) {
            const datosServicio = $($items[indiceSeleccionado]).data('datos-servicio');
            if (datosServicio) {
                agregarServicioSeleccionado(datosServicio);
            }
        }
    }
}

function actualizarSeleccion_vistacrearnotas($items) {
    $items.removeClass('active-suggestion');
    if (indiceSeleccionado !== -1) {
        const $itemSeleccionado = $($items[indiceSeleccionado]);
        $itemSeleccionado.addClass('active-suggestion');

        // Asegura que el elemento sea visible si la lista es muy larga
        const contenedorScrollTop = $sugerenciasContenedor.scrollTop();
        const itemTop = $itemSeleccionado.position().top;
        const contenedorAltura = $sugerenciasContenedor.height();

        if (itemTop < 0) {
            $sugerenciasContenedor.scrollTop(contenedorScrollTop + itemTop);
        } else if (itemTop + $itemSeleccionado.outerHeight() > contenedorAltura) {
            $sugerenciasContenedor.scrollTop(contenedorScrollTop + itemTop + $itemSeleccionado.outerHeight() - contenedorAltura);
        }
    }
}

function agregarServicioSeleccionado(servicio) {
    // alertify.success("Servicio '" + servicio.servicio_nombre + "' agregado.");

    // Aquí se usa tu función original para añadir la fila a la tabla
    agregar_servicio_tablaservicio_vistanotas(servicio);
    recalcularTotal_tablaservicio_vistanotas(); // Esto es importante, si tienes la función

    // Limpia el input y el contenedor de sugerencias
    $inputBuscador.val('');
    $sugerenciasContenedor.empty().hide();
}

function api_backend_buscarservicios_nota(texto) {
    $.ajax({
        type: "POST",
        url: urlweb + "api/Servicios/buscar_servicio_nombreycodigo", // URL a tu endpoint
        data: { query: texto },
        success: function(respuesta) {
            $sugerenciasContenedor.empty().show();
            const res = JSON.parse(respuesta);
            const servicios = res.result.data;

            if (servicios.length > 0) {
                servicios.forEach(function(servicio) {
                    const $itemSugerencia = $('<div>')
                        .text(servicio.servicio_nombre)
                        .data('datos-servicio', servicio);

                    // Al hacer clic, se agrega el servicio a la tabla
                    $itemSugerencia.on('click', function() {
                        const datosServicio = $(this).data('datos-servicio');
                        agregarServicioSeleccionado(datosServicio);
                    });
                    $sugerenciasContenedor.append($itemSugerencia);
                });
            } else {
                $sugerenciasContenedor.append($('<div>').text('No se encontraron servicios'));
            }
        },
        error: function() {
            console.error("Error al buscar servicios.");
            $sugerenciasContenedor.empty().hide();
        }
    });
}

function configurarEventosON_Autocompletado_BuscarserviciosInput_Notas() {
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
            api_backend_buscarservicios_nota(textoBuscado);
        }, 300);
    });

    // Maneja las teclas de navegación (flechas y Enter)
    $inputBuscador.on('keydown', manejarTeclas_inputbusquedaservicio_notas);

    // Oculta las sugerencias si haces clic en otro lado de la página
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-container').length) {
            $sugerenciasContenedor.empty().hide();
        }
    });
}
//*


//Logica de la tabla Servicios Notas
function seleccionar_servicio_tablamodalservicio_vistacrearnota($btn){
    const servicio = JSON.parse($btn.attr('data-service'));
    agregar_servicio_tablaservicio_vistanotas(servicio);
    recalcularTotal_tablaservicio_vistanotas();  // recalcula al agregar
}

function agregar_servicio_tablaservicio_vistanotas(servicio){
    //evito ducplicar servicios a la tabla
    if ($(".tabla_servicio tbody tr[data-id='" + servicio.id_servicio + "']").length > 0) {
        return;
    }

    const fila = `
      <tr data-id="${servicio.id_servicio}">
        <td>${servicio.id_servicio}</td>
        <td>
          <input type="text"
                 class="form-control form-control-sm inputnombre-socio_tabla"
                 value="${servicio.servicio_nombre}">
        </td>
        <td>
          <input type="number"
                 class="form-control form-control-sm inputcantidad-socio_tabla"
                 value="1" min="1">
        </td>
        <td> 
            <input type="number"
                 class="form-control form-control-sm inputprecio-socio_tabla"
                 value="${Number(servicio.servicio_precio_socio).toFixed(2)}"
                 min="0" step="0.01">
        </td>
        <td> 
            <input type="number"
                 class="form-control form-control-sm inputsubtotal_socio_tabla"
                 value="${Number(servicio.servicio_precio_socio).toFixed(2)}"
                 min="0" step="0.01"
            >
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm btn-quitar-servicio">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
    `;


    $inputBuscador.val('');
    $(".tabla_servicio tbody").append(fila);
}

function recalcularTotal_tablaservicio_vistanotas() {
    let total = 0;
    $('.tabla_servicio tbody .inputsubtotal_socio_tabla').each(function () {
        const v = parseFloat($(this).val());
        if (!isNaN(v)) total += v;
    });

    // $('.tabla_servicio tbody tr').each(function () {
    //     const texto = $(this).find('.inputsubtotal_socio_tabla').text().replace('S/.','').trim();
    //     const v = parseFloat(texto) || 0;
    //     total += v;
    // });

    $('#idlabeltotalventa').text('S/. ' + total.toFixed(2));
    $('#idlabeltotalexonerada').text('S/. ' + total.toFixed(2));
}

function actualizarSubtotalFila_tablaservicio_vistanotas($tr) {
    const cantidad = parseFloat($tr.find('.inputcantidad-socio_tabla').val()) || 0;
    const precio   = parseFloat($tr.find('.inputprecio-socio_tabla').val()) || 0;
    const subtotal = cantidad * precio;
    $tr.find('.inputsubtotal_socio_tabla').val(subtotal.toFixed(2));
}
//*