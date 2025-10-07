const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

function guardar_atencion(formData){
    formData.append("fecha", fechaLocal);

    // DEBUG: ver qué se está enviando
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    $.ajax({
        url: urlweb + "api/Atencion/guardar_atencion",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            cambiar_estado_boton('idbtnguardar_atencion', 'Guardando...', true);
        },
        success: function (r) {
            let data = JSON.parse(r); // 👈 convierte string a objeto
            cambiar_estado_boton('idbtnguardar_atencion', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            respuesta(data.result.message, data.result.success ? "success" : "error");

            if (data.result.success) {
                $("#idmodalnuevoatencionCenter").modal("hide");
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr, status, error) {
            cambiar_estado_boton('idbtnguardar_atencion', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            alert("Hubo un error al guardar el beneficio.");
        }
    });
}

function eliminar_atencion(idatencion){
    $.ajax({
        type: "POST",
        url: urlweb + "api/Atencion/eliminar_atencion",
        data: {
            idatencion: idatencion
        },
        dataType: "json",
        beforeSend: function () {
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    // aquí puedes limpiar si necesitas
                }
            });
        },
        success: function (r) {
            Swal.close();
            respuesta(r.result.message, r.result.success ? "success" : "error");

            if (r.result.success) {
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr) {
            Swal.close();
            console.error("Error en la petición eliminar_categoriabeneficio:", xhr.responseText);
        }
    });
}

function limpiar_formularioatencion(){
    $("#idatencion").val("");
    $("#dni").val("");
    $("#nombre").val("");
    $("#area").val(0);
    $("#motivo").val("");
    $("#observacion").val("");
    $("#idmodalnuevoatencionCenterLabel").text("Nuevo Atencion");
}

function almacenareditar_formularioatencion(id, dni, nombre, area, motivo, observa){
    $("#idatencion").val(id);
    $("#dni").val(dni);
    $("#nombre").val(nombre);
    $("#area").val(area);
    $("#motivo").val(motivo);
    $("#observacion").val(observa);
}

async function buscar_dni_api() {
    let valor = $("#dni").val().trim();
    $("#nombre").val("");

    cambiar_estado_boton('idbtnbuscarcliente', 'Buscando...', true);

    try {
        let arrayDatos = await consultarNumdocumentoAPIV2_simple(valor);
        $("#nombre").val(arrayDatos[0].nombre);
        respuesta("Datos encontrados", "success");
    } catch (error) {
        respuesta(error, "error");
    } finally {
        // ✅ pase lo que pase, reactivamos el botón
        cambiar_estado_boton('idbtnbuscarcliente', 'Buscar Cliente', false);
    }
}

