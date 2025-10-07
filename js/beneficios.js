const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

function limpiar_inputsmodal_vistabeneficio(){
    $('#idinputbeneficio_descripcion').val("");
    $('#idinput_tipobeneficio').val(0);
    $('#idinputbeneficio_nombre').val("");
    $('#id_beneficio').val("0");
}

function almacenareditar_beneficio(id_beneficio, nombre, descripcion, tipobeneficio){
    $('#idinputbeneficio_descripcion').val(descripcion);
    $('#idinput_tipobeneficio').val(tipobeneficio);
    $('#idinputbeneficio_nombre').val(nombre);
    $('#id_beneficio').val(id_beneficio);
}


function guardar_beneficio(formData){
    formData.append("fecha", fechaLocal);

    // DEBUG: ver qué se está enviando
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    $.ajax({
        url: urlweb + "api/Beneficios/guardar_beneficio",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            cambiar_estado_boton('idbtnguardar_beneficio', 'Guardando...', true);
        },
        success: function (r) {
            let data = JSON.parse(r); // 👈 convierte string a objeto
            cambiar_estado_boton('idbtnguardar_beneficio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            respuesta(data.result.message, data.result.success ? "success" : "error");

            if (data.result.success) {
                $("#idmodalnuevobeneficio_vistabeneficio").modal("hide");
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr, status, error) {
            cambiar_estado_boton('idbtnguardar_beneficio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            alert("Hubo un error al guardar el beneficio.");
        }
    });
}

function eliminar_beneficioAPI(id_beneficio){
    $.ajax({
        type: "POST",
        url: urlweb + "api/Beneficios/eliminar_beneficio",
        data: {
            idbeneficio: id_beneficio
        },
        dataType: "json",
        beforeSend: function () {
            Swal.fire({
                title: 'Eliminado Beneficio...',
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