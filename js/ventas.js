const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

// Variables globales para la CUOTA Y vNETA credito
let cuotaCounter = 0;
let cuotasData = [];
let MAX_IMPORTE = 2000;
let cuotalimpiarbool = false;
//*

// Variables globales para el estado del buscador de servicios y sugerencas
let idTemporizador = null;
let indiceSeleccionado = -1;
const $inputBuscador = $('#product_search_input');
const $sugerenciasContenedor = $('#product_suggestions');
//*


function vista_previa_venta() {
    let message = "";
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
    let idcliente = $("#idinput_idclienteventa").val();
    let ventatotal = $("#idlabeltotalventa").text();
    let ventatotalexonerada = $("#idlabeltotalexonerada").text();

    let valor_ = true;

    // === Validaciones (igual que en realizar_venta) ===
    if (tipo_venta === "01") {
        if (!(client_number.length === 11 && select_tipodocumento === "4")) {
            valor_ = false;
            message = "El RUC debe tener 11 dígitos. Verifique si intenta generar BOLETA o FACTURA";
        }
    }
    else if (tipo_venta === "03") {
        if (select_tipodocumento === "2" || select_tipodocumento === "3") {
            if (client_number.length !== 8) {
                valor_ = false;
                message = "El DNI debe tener 8 dígitos. Verifique si intenta generar BOLETA o FACTURA";
            }
        } else {
            valor_ = false;
            message = "Ocurrió un error en los parámetros, por favor revise cuidadosamente.";
        }
    }

    if (!valor_) {
        respuesta(message, "error");
        return;
    }

    if (idselectformapago === "2") {
        if (cuotasData.length < 0) {
            respuesta("No se encontró Cuotas de Pago, por favor seleccione otra forma de pago", "error");
            return;
        }

        if (!validarFormularioCuota()) {
            respuesta("Por favor, corrija los errores antes de guardar.", "error");
            return;
        }
    }

    // === Recolectar productos (igual que en realizar_venta) ===
    let datosventaactual = [];
    $(".tabla_servicio tbody tr").each(function () {
        const $tr = $(this);
        const obj = {
            id_servicio: $tr.data("id"),
            venta_detalle_nombre_servicio: $tr.find(".inputnombre-socio_tabla").val(),
            venta_detalle_cantidad_servicio: $tr.find(".inputcantidad-socio_tabla").val(),
            venta_detalle_precio_unitario: $tr.find(".inputprecio-socio_tabla").val(),
            venta_detalle_valor_total: parseFloat($tr.find(".inputsubtotal_socio_tabla").val()) || 0,
        };
        datosventaactual.push(obj);
    });

    if (datosventaactual.length <= 0) {
        respuesta("El carrito está vacío, agregue un servicio", "error");
        return;
    }

    // === Objeto de venta (igual que en realizar_venta) ===
    const ventas = {
        id_cliente: idcliente,
        id_tipo_pago: id_tipo_pago,
        venta_tipo_moneda: tipo_moneda,
        venta_tipo_envio: tipo_venta,
        venta_tipo: tipo_venta,
        venta_serie: serie,
        venta_correlativo: numero,
        producto_venta_des_global: 1,
        venta_totalexonerada: ventatotalexonerada.replace("S/.", "").trim(),
        producto_venta_totalinafecta: 1,
        producto_venta_totaligv: 1,
        venta_total: ventatotal.replace("S/.", "").trim(),
        venta_fecha: fechaLocal, // asegúrate de que existe en tu scope
        tipo_documento_modificar: select_tipodocumento,
        detalle_venta: datosventaactual,
        venta_forma_pago: idselectformapago,
        detalle_cuota: obtenerDatosCuotas(),
        client_name: client_name,
        client_direccion: client_direccion,
        client_number: client_number,
        preview: 1 // <<<<<< clave
    };

    // === Mostrar modal con loader ===
    $("#idmodalpdfdemo").modal("show");
    $("#loader").show();
    $("#iframe_preview").hide();

    // === Llamada AJAX para la vista previa del PDF ===
    $.ajax({
        type: "POST",
        url: urlweb + "Ventas/vistaprevia_pdf_a4",
        data: ventas,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (blob) {
            let url = URL.createObjectURL(blob);
            let iframe = document.getElementById("iframe_preview");
            iframe.src = url;

            $("#loader").hide();
            $("#iframe_preview").show();
        },
        error: function () {
            respuesta("Error generando vista previa", "error");
            $("#loader").hide();
        }
    });
}





function realizar_venta(){
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
    let idcliente = $("#idinput_idclienteventa").val();
    let ventatotal = $("#idlabeltotalventa").text();
    MAX_IMPORTE = ventatotal;
    let ventatotalexonerada = $("#idlabeltotalexonerada").text();


    let Tipo_documento_modificar = "";
    let serie_modificar = "";
    let numero_modificar = "";
    let notatipo_descripcion = "";
    let valor = false;
    let valor_ = true;
    if (tipo_venta === "07" || tipo_venta === "08"){
        Tipo_documento_modificar = $('#Tipo_documento_modificar').val();
        serie_modificar = $('#serie_modificar').val();
        numero_modificar = $('#numero_modificar').val();
        notatipo_descripcion = $('#notatipo_descripcion').val();
    }

    if(tipo_venta === "01"){
        if(client_number.length === 11 && select_tipodocumento === "4"){
            valor_ = true;
        }else{
            valor_ = false;
            message = "El RUC debe tener 11 dígitos. Verifique si intenta generar BOLETA o FACTURA";
        }

    }
    else if (tipo_venta === "03"){
        if(select_tipodocumento === "2" || select_tipodocumento === '3'){
            if(client_number.length === 8){
                valor_ =true;
            }else{
                valor_ = false;
                message = "El DNI debe tener 8 dígitos. Verifique si intenta generar BOLETA o FACTURA";
            }
        } else {
            valor_ = false;
            message = "Ocurrio un error en los parametros, Porfavor Revise cuidadosamente.";
        }
    }

    if(!valor_){
        respuesta(message, 'error');
        return;
    }

    if (idselectformapago === "2"){
        if(cuotasData.length < 0){
            respuesta("No se encontró Cuotas de Pago, porfavor selecciona otra forma de pago", 'error');
            return;
        }

        if (!validarFormularioCuota()) {
            respuesta("Por favor, corrija los errores antes de guardar.", 'error');
            return;

            const datos = obtenerDatosCuotas();
            console.log("Datos guardados:", datos);

            mostrarMensajeGeneral("¡Datos guardados correctamente!", "success");
        } else {
            mostrarMensajeGeneral("Por favor, corrija los errores antes de guardar.", "error");
        }
        message = "El DNI debe tener 8 dígitos. Verifique si intenta generar BOLETA o FACTURA";
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
        tipo_documento_modificar : select_tipodocumento,
        // serie_modificar : "",
        // numero_modificar : "",
        // notatipo_descripcion : "",
        // venta_nota_dato : "",
        detalle_venta : datosventaactual,
        venta_forma_pago: idselectformapago,
        detalle_cuota : obtenerDatosCuotas(),
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

function enviar_comprobante_sunat(id_venta) {
    var cadena = "id_venta=" + id_venta;
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/crear_xml_enviar_sunat",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "<i style=\"font-size: 16pt;\" class=\"fa fa-check margen\"></i>", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
            }
        }

    });
}

function comunicacion_baja(id_venta){
    let cadena = "id_venta=" + id_venta;
    let boton = 'btn_anular'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/comunicacion_baja",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function anular_boleta_cambiarestado(id_venta, estado){
    var cadena = "id_venta=" + id_venta + "&estado=" + estado;
    var boton = 'btn_anular_boleta'+id_venta;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/anular_boleta_cambiarestado",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Comprobante Anulado, listo para ser enviado por Resumen Diario!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al anular el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function crear_enviar_resumen_sunat(){
    var fecha_post = $('#fecha_post').val();
    var cadena = "fecha=" + fecha_post;
    var boton = 'boton_enviar_resumen';
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/crear_enviar_resumen_sunat",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "Enviar Comprobantes", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡Resumen Creado y Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el Resumen Diario', 'error');
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    break;
                case 4:
                    respuesta(r.result.message, 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function seleccionar_servicio_tablamodalservicio($btn){
    const servicio = JSON.parse($btn.attr('data-service'));
    agregar_servicio_tablaservicio(servicio);
    recalcularTotal();  // recalcula al agregar
}

function agregar_servicio_tablaservicio(servicio){
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
                 class="form-control form-control-sm inputsubtotal_socio_tabla" readonly
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

function recalcularTotal() {
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

function actualizarSubtotalFila_tablaservicio($tr) {
    const cantidad = parseFloat($tr.find('.inputcantidad-socio_tabla').val()) || 0;
    const precio   = parseFloat($tr.find('.inputprecio-socio_tabla').val()) || 0;
    const subtotal = cantidad * precio;
    $tr.find('.inputsubtotal_socio_tabla').val(subtotal.toFixed(2));
}
//*

function agregarCuota() {
    cuotaCounter++;

    const fechaMinima = obtenerFechaMinima();

    const cuotaHtml = `
        <div class="cuota-row" data-cuota="${cuotaCounter}">
            <div class="row align-items-center">
                <div class="col-lg-2 col-3 ">
                    <div class="cuota-number text-center">${cuotaCounter}</div>
                </div>
                <div class="col-lg-3 col-4">
                    <input class="form-control importe-input" 
                           type="number" 
                           step="0.01" 
                           min="0.01" 
                           max="${MAX_IMPORTE}" 
                           data-cuota="${cuotaCounter}"
                           placeholder="0.00">
                    <div class="error-message" id="error-importe-${cuotaCounter}"></div>
                </div>
                <div class="col-lg-4 col-4">
                    <input class="form-control fecha-input" 
                           type="date" 
                           min="${fechaMinima}"
                           data-cuota="${cuotaCounter}">
                    <div class="error-message" id="error-fecha-${cuotaCounter}"></div>
                </div>
                <div class="col-lg-3 col-1 text-center">
                    <button type="button" class="btn btn-danger btn-eliminar my-1" data-cuota="${cuotaCounter}">
                        <i class="fa fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    `;

    $("#cuotas-container").append(cuotaHtml);
    actualizarTotales();
}

// Obtener fecha mínima (mañana)
function obtenerFechaMinima() {
    let manania = new Date();
    manania.setDate(manania.getDate() + 1);

    // Convertir a formato YYYY-MM-DD en local
    const anio = manania.getFullYear();
    const mes = String(manania.getMonth() + 1).padStart(2, '0');
    const dia = String(manania.getDate()).padStart(2, '0');

    return `${anio}-${mes}-${dia}`;
}


// Renumerar cuotas después de eliminar
function renumerarCuotas() {
    let contador = 1;
    $("#cuotas-container .cuota-row").each(function() {
        $(this).attr("data-cuota", contador);
        $(this).find(".cuota-number").text(contador);
        $(this).find(".importe-input").attr("data-cuota", contador);
        $(this).find(".fecha-input").attr("data-cuota", contador);
        $(this).find(".btn-eliminar").attr("data-cuota", contador);
        $(this).find(".error-message").attr("id", function(i, oldId) {
            return oldId.replace(/\d+$/, contador);
        });
        contador++;
    });
    cuotaCounter = contador - 1;
}

// Calcular suma total
function calcularSumaTotal() {
    let suma = 0;
    $(".importe-input").each(function() {
        const valor = parseFloat($(this).val()) || 0;
        suma += valor;
    });
    return suma;
}

// Actualizar totales
function actualizarTotales() {
    const totalCuotas = $("#cuotas-container .cuota-row").length;
    const sumaTotal = calcularSumaTotal();

    $("#total-cuotas").text(totalCuotas);
    $("#suma-total").text(sumaTotal.toFixed(2));
}

// Validar formulario completo

function validarFormularioCuota() {
    let esValido = true;
    const errores = [];

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Normalizar

    const fechasIngresadas = [];

    let fechaAnterior = null;

    $(".cuota-row").each(function (index) {
        const cuotaNum = $(this).find(".cuota-number").text();
        const importe = $(this).find(".importe-input").val();
        const fechaStr = $(this).find(".fecha-input").val();

        // Validar importe
        if (!importe || parseFloat(importe) <= 0) {
            errores.push(`Cuota ${cuotaNum}: Debe ingresar un importe válido`);
            esValido = false;
        }

        // Validar fecha no vacía
        if (!fechaStr) {
            errores.push(`Cuota ${cuotaNum}: Debe seleccionar una fecha`);
            esValido = false;
        } else {
            const fecha = new Date(fechaStr + "T00:00:00"); // Evita problemas de zona horaria

            // Validar que sea al menos mañana
            if (fecha <= hoy) {
                errores.push(`Cuota ${cuotaNum}: La fecha debe ser mayor al día actual`);
                esValido = false;
            }

            // Validar duplicados
            if (fechasIngresadas.includes(fechaStr)) {
                errores.push(`Cuota ${cuotaNum}: La fecha está repetida con otra cuota`);
                esValido = false;
            } else {
                fechasIngresadas.push(fechaStr);
            }

            // Validar secuencia cronológica
            if (fechaAnterior && fecha <= fechaAnterior) {
                errores.push(`Cuota ${cuotaNum}: La fecha debe ser mayor a la cuota anterior`);
                esValido = false;
            }

            fechaAnterior = fecha;
        }
    });

    // Validar suma total
    const sumaTotal = calcularSumaTotal();
    if (sumaTotal > MAX_IMPORTE) {
        errores.push(
            `La suma total (S/ ${sumaTotal.toFixed(2)}) excede el límite de S/ ${MAX_IMPORTE}.00`
        );
        esValido = false;
    }

    // Mostrar errores
    if (errores.length > 0) {
        const mensajeError = errores
            .map((error) => `<div class="alert alert-danger py-1 mb-1">${error}</div>`)
            .join("");
        $("#validation-messages").html(mensajeError);
    } else {
        $("#validation-messages").empty();
    }

    return esValido;
}

function guardar_cuotas() {
    if (validarFormularioCuota()) {
        const datos = obtenerDatosCuotas();

        // VALIDACIÓN SIMPLE: Sumar todos los importes
        let sumaTotal = 0;
        $(".importe-input").each(function() {
            sumaTotal += parseFloat($(this).val()) || 0;
        });

        const maxImporte = parseFloat(MAX_IMPORTE); // Aseguramos que es número

        // Comparar con tolerancia
        if (Math.abs(sumaTotal - maxImporte) > 0.01) {
            mostrarMensajeGeneral(
                `La suma de las cuotas (S/ ${sumaTotal.toFixed(2)}) debe ser igual al monto total (S/ ${maxImporte.toFixed(2)})`,
                "error"
            );
            return; // No continúa si no coincide
        }

        console.log("Datos guardados:", datos);
        mostrarMensajeGeneral("¡Datos guardados correctamente!", "success");

        // Aquí tu AJAX o cerrar modal
        setTimeout(() => {
            cuotalimpiarbool = true;
            $("#idmodalcredito").modal("hide");
        }, 1000);
    }
    // else {
    //     mostrarMensajeGeneral("Por favor, corrija los errores antes de guardar.", "error");
    // }
}


function guardar_cuotas1(){
    if (validarFormularioCuota()) {
        const datos = obtenerDatosCuotas();

        // VALIDACIÓN SIMPLE: Sumar todos los importes
        let sumaTotal = 0;
        $(".importe-input").each(function() {
            sumaTotal += parseFloat($(this).val()) || 0;
        });

        // Comparar con la variable constante fija
        if (Math.abs(sumaTotal - parseFloat(MAX_IMPORTE)) > 0.01) { // Tolerancia de 1 centavo
            mostrarMensajeGeneral(`La suma de las cuotas (S/ ${sumaTotal.toFixed(2)}) debe ser igual al monto total (S/ ${parseFloat(MAX_IMPORTE.toFixed(2))})`, "error");
            return; // No continúa si no coincide
        }

        console.log("Datos guardados:", datos);
        mostrarMensajeGeneral("¡Datos guardados correctamente!", "success");

        // Aquí tu AJAX o cerrar modal
        setTimeout(() => {
            cuotalimpiarbool = true;
            $("#idmodalcredito").modal("hide");
        }, 1000);
    } else {
        mostrarMensajeGeneral("Por favor, corrija los errores antes de guardar.", "error");
    }
}

function validarFormularioCuota1() {
    let esValido = true;
    const errores = [];

    // Validar que todas las cuotas tengan importe y fecha
    $(".cuota-row").each(function() {
        const cuotaNum = $(this).find(".cuota-number").text();
        const importe = $(this).find(".importe-input").val();
        const fecha = $(this).find(".fecha-input").val();

        if (!importe || parseFloat(importe) <= 0) {
            errores.push(`Cuota ${cuotaNum}: Debe ingresar un importe válido`);
            esValido = false;
        }

        if(fecha !== fechaLocal){
            errores.push(`la cuota debe ser mayor a la fecha actual`);
            esValido = false;
        }

        if (!fecha) {
            errores.push(`Cuota ${cuotaNum}: Debe seleccionar una fecha`);
            esValido = false;
        }
    });

    // Validar suma total
    const sumaTotal = calcularSumaTotal();
    if (sumaTotal > MAX_IMPORTE) {
        errores.push(`La suma total (S/ ${sumaTotal.toFixed(2)}) excede el límite de S/ ${MAX_IMPORTE}.00`);
        esValido = false;
    }

    // Mostrar errores
    if (errores.length > 0) {
        const mensajeError = errores.map(error => `<div class="alert alert-danger py-1 mb-1">${error}</div>`).join("");
        $("#validation-messages").html(mensajeError);
    } else {
        $("#validation-messages").empty();
    }

    return esValido;
}

// Obtener datos de las cuotas
function obtenerDatosCuotas() {
    cuotasData = [];
    let id_tipo_pago = $("#id_tipo_pago").val();

    $(".cuota-row").each(function() {
        const cuotaNum = parseInt($(this).find(".cuota-number").text());
        const importe = parseFloat($(this).find(".importe-input").val()) || 0;
        const fecha = $(this).find(".fecha-input").val();

        cuotasData.push({
            venta_cuota_numero: cuotaNum,
            venta_cuota_importe: importe,
            venta_cuota_fecha: fecha
        });
    });

    return {
        id_tipo_pago: id_tipo_pago,
        cuotas: cuotasData,
        totalCuotas: cuotasData.length,
        sumaTotal: cuotasData.reduce((sum, cuota) => sum + cuota.venta_cuota_importe, 0)
    };
}

// Mostrar mensaje general
function mostrarMensajeGeneral(mensaje, tipo = "error") {
    const clase = tipo === "error" ? "alert-danger" : "alert-success";
    const html = `<div class="alert ${clase} py-2">${mensaje}</div>`;
    $("#validation-messages").html(html);

    setTimeout(() => {
        $("#validation-messages").empty();
    }, 3000);
}



function consultar_documento(valor){
    let tipo_venta = $("#tipo_venta").val();
    if(valor.trim() === '') {
        $("#idinput_idclienteventa").val('');
        $("#client_name").val('');
        $("#client_address").val('');
        return;
    }

    if(tipo_venta === "01" && valor.length !== 11){
        $("#idinput_idclienteventa").val('');
        $("#client_name").val('');
        $("#client_address").val('');
        respuesta("El Ruc requiere de 11 dígitos", "error");
        return;
    }

    if(tipo_venta === "03" && valor.length !== 8){
        $("#idinput_idclienteventa").val('');
        $("#client_name").val('');
        $("#client_address").val('');
        respuesta("El DNI requiere de 8 dígitos", "error");
        return;
    }

    // if(valor.length === 8){
    //     $("#tipo_venta").val("03");
    //     // Consultar_serie();
    // }else if(valor.length === 11){
    //     $("#tipo_venta").val("01");
    //     // Consultar_serie();
    // } else{
    //     respuesta(tipo_venta === "01" ? "El Ruc requiere de 11 dígitos" : "El DNI requiere de 8 dígitos", "error");
    //     return;
    // }

    $.ajax({
        type: "POST",
        url: urlweb + "api/Clientes/obtener_datos_x_numdocumento",
        data: {
            numero: valor
        },
        dataType: 'json',
        success: function (r) {
            console.log("consultar_documento consulta 2");
            // Consultar_serie();
            if (!r || !r.result) {
                consultarAPIExterna();
                return;
            }

            if (!r.result.success) {
                consultarAPIExterna();
                return;
            }


            const clienteData = r.result.data;
            if (clienteData && (clienteData.id_cliente || clienteData.cliente_numero || clienteData.cliente_nombre || clienteData.cliente_razonsocial)) {

                let nombreCliente = '';
                if (tipo_venta === "01") { // Factura
                    nombreCliente = clienteData.cliente_razonsocial || clienteData.cliente_nombre || '';
                } else {
                    nombreCliente = clienteData.cliente_nombre || clienteData.cliente_razonsocial || '';
                }

                $("#idinput_idclienteventa").val(clienteData.id_cliente);
                $("#client_name").val(nombreCliente);
                $("#client_address").val(clienteData.cliente_direccion || '');

                respuesta("Cliente encontrado en base de datos", "success");
                return;
            }

            // Si llega aca, no encontró en la bd, bufrca en la api

            consultarAPIExterna();
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", error);
            respuesta("Error de conexión con base de datos", "warning");
            consultarAPIExterna();
        }
    });
}

//API externa DOC
function consultarAPIExterna() {
    $("#idinput_idclienteventa").val("0");
    consultarNumdocumentoAPI(
        'select_tipodocumento',
        'client_number',
        'client_name',
        'client_address'
    );
}


//Logica para el BUscador de servicios y sugerencias
function manejarTeclas(e) {
    const $items = $sugerenciasContenedor.find('div');
    const totalItems = $items.length;

    if (totalItems === 0 || $items.text() === 'No se encontraron servicios') return;

    // Flecha Abajo
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        indiceSeleccionado = (indiceSeleccionado + 1) % totalItems;
        actualizarSeleccion($items);
    }
    // Flecha Arriba
    else if (e.key === 'ArrowUp') {
        e.preventDefault();
        indiceSeleccionado = (indiceSeleccionado - 1 + totalItems) % totalItems;
        actualizarSeleccion($items);
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

function actualizarSeleccion($items) {
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
    agregar_servicio_tablaservicio(servicio);
    recalcularTotal(); // Esto es importante, si tienes la función

    // Limpia el input y el contenedor de sugerencias
    $inputBuscador.val('');
    $sugerenciasContenedor.empty().hide();
}

function buscarServicios(texto) {
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
//*