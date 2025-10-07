function editar_cobrito(id) {
    $("#generar_cobrito_"+id).removeClass('readonly_select');
    $("#tipo_paguito_"+id).removeClass('readonly_select');
    $("#forma_paguito_"+id).removeClass('readonly_select');
    $("#descripcion_"+id).removeClass('readonly_select');
    $("#btn_actualizar_"+id).removeClass('no-show');
    $("#btn_editar_"+id).addClass('no-show');
}

function actualizar_cobrito(id) {
    var valor = $('#generar_cobrito_'+id).val();
    var tipo_pago = $('#tipo_paguito_'+id).val();
    var forma_pago = $('#forma_paguito_'+id).val();
    var descripcion = $('#descripcion_'+id).val();
    var cadena =
        "id=" + id+
        "&tipo_pago="+tipo_pago+
        "&forma_pago="+forma_pago+
        "&descripcion="+descripcion+
        "&cobrar="+valor;
    $.ajax({
        type:"POST",
        url: urlweb + "api/cobranza/actualizar_cobrito",
        data: cadena,
        dataType: 'json',
        beforeSend: function () {
            $("#generar_cobrito_"+id).addClass('readonly_select');
        },
        success:function (r) {
            console.log(r);
            if(r==1) {
                respuesta('¡Guardado!', 'success');
                //Nuevos botones
                $("#generar_cobrito_"+id).addClass('readonly_select');
                $("#tipo_paguito_"+id).addClass('readonly_select');
                $("#forma_paguito_"+id).addClass('readonly_select');
                $("#descripcion_"+id).addClass('readonly_select');
                //Fin de nuevos botones
                $("#btn_actualizar_" + id).addClass('no-show');
                $("#btn_editar_" + id).removeClass('no-show');
            }else{
                //Nuevos botones
                $("#generar_cobrito_"+id).removeClass('readonly_select');
                $("#tipo_paguito_"+id).removeClass('readonly_select');
                $("#forma_paguito_"+id).removeClass('readonly_select');
                $("#descripcion_"+id).removeClass('readonly_select');
                //Fin de nuevos botones
                $("#btn_actualizar_"+id).removeClass('no-show');
                $("#btn_editar_"+id).addClass('no-show');
                respuesta('¡Ocurrió Un Error!', 'error');
            }
        }
    });
}

$("#formAdjuntarComprobante").on('submit', function (e) {
    e.preventDefault();

    var action = $(e.originalEvent.submitter).data("action");
    if (action === "delete") {
        return;
    }

    var valor = true;
    var boton = "btnGuardarComprobante";
    var id_cobranza_b = $('#id_cobranza_b').val();
    var comprobante_ruta = $('#comprobante_ruta').val();

    var comprobante_texto_general = $('#comprobante_texto_general').val();
    var comprobante_monto_general = $('#comprobante_monto_general').val();

    // Validamos si los campos a usar no se encuentran vacíos
    //valor = validar_campo_vacio('comprobante_descripcion', comprobante_descripcion, valor);
    //valor = validar_campo_vacio('comprobante_ruta', comprobante_ruta, valor);

    if (valor) {
        $.ajax({
            type: "POST",
            url: urlweb + "api.php?c=cobranza&a=guardar_comprobante",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "<i class='fa fa-save'></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Comprobante guardado exitosamente!', 'success');
                        listarComprobantes(id_cobranza_b, comprobante_monto_general, comprobante_texto_general);
                        $('#comprobante_descripcion').val('');
                        $('#comprobante_ruta').val('');
                        break;
                    case 3:
                        respuesta('Archivo no seleccionado', 'error');
                        break;
                    default:
                        respuesta('¡Ocurrió un error al guardar el comprobante!', 'error');
                        break;
                }
            }
        });
    }
});

function abrirModalComprobante(id_cobranza, monto, texto) {
    $("#modalAdjuntarComprobanteLabel").html("Registrar Pago - " + texto);
    $('#id_cobranza_b').val(id_cobranza);
    $('#comprobante_monto').val(monto);

    $('#comprobante_texto_general').val(texto);
    $('#comprobante_monto_general').val(monto);
    listarComprobantes(id_cobranza);
}
function listarComprobantes(id_cobranza) {
    $('#tablaComprobantes').empty();
    /*let body =
    `
        <tr>
            <td>Recibo General</td>
            <td>
                <a href="${urlweb}credito/generar_recibo_pdf_general_normal/${id_cronograma}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
            </td>
            <td>

            </td>
        </tr>
    `
    $('#tablaComprobantes').append(body);*/
    $.ajax({
        url: urlweb + "api.php?c=cobranza&a=listar_comprobantes",
        type: "POST",
        data: { id_cobranza: id_cobranza },
        success: function (r) {

            let data = JSON.parse(r);
            let comprobantes = data.result;

            if (Array.isArray(comprobantes)) {

                let tablaComprobantes = $('#tablaComprobantes');
                // tablaComprobantes.empty();

                comprobantes.forEach(function (comprobante) {
                    let botones = "";

                    if (comprobante.comprobante_ruta && comprobante.comprobante_ruta.trim() !== "") {
                        botones = `
                        <a href="${urlweb + comprobante.comprobante_ruta}" 
                           target="_blank" 
                           class="btn btn-sm btn-info" 
                           title="Ver comprobante">
                           <i class="fa fa-eye"></i>
                        </a>
                        <a href="${urlweb + comprobante.comprobante_ruta}" 
                           download="${comprobante.comprobante_ruta_descarga}" 
                           class="btn btn-sm btn-warning" 
                           title="Descargar comprobante">
                           <i class="fa fa-download"></i>
                        </a>
                    `;
                    }

                    let fila = `
                        <tr id="fila_${comprobante.id_comprobante_cob}">
                            <td>${comprobante.comprobante_monto}</td>
                            <td>${comprobante.comprobante_fecha}</td>
                            <td class="text-center">
                                ${botones}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" 
                                        data-action="delete" 
                                        onclick="eliminarComprobante(${comprobante.id_comprobante_cob})"
                                        title="Eliminar comprobante">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tablaComprobantes.append(fila);
                });


            }
        },
        error: function (err) {
            console.log("Error al listar comprobantes:", err);
        }
    });
}

function eliminarComprobante(id_comprobante_cob) {
    var comprobante_texto_general = $('#comprobante_texto_general').val();
    var comprobante_monto_general = $('#comprobante_monto_general').val();
    var id_cobranza_b = $('#id_cobranza_b').val();
    $('#modalAdjuntarComprobante').modal('hide');
    $('#confirmDeleteModal').modal('show');

    $('#confirmDeleteBtn').off('click').on('click', function () {
        $.ajax({
            type: "POST",
            url: urlweb + "api.php?c=cobranza&a=eliminar_comprobante",
            data: { id_comprobante_cob: id_comprobante_cob, id_cobranza_b: id_cobranza_b },
            dataType: 'json',
            beforeSend: function () {
                $('#confirmDeleteBtn').text('Eliminando...').prop('disabled', true);
            },
            success: function (r) {
                if (r.result.code == 1) {
                    respuesta('¡Comprobante eliminado correctamente!', 'success');
                    listarComprobantes(id_cobranza_b, comprobante_monto_general, comprobante_texto_general);
                } else {
                    respuesta('Error al eliminar el comprobante', 'error');
                }
            },
            complete: function () {
                $('#confirmDeleteBtn').text('Sí, Eliminar').prop('disabled', false);
                $('#confirmDeleteModal').modal('hide');
            }
        });
    });
}