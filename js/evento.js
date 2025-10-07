const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

function guardar_evento(formData){
    formData.append("fecha", fechaLocal);

    // DEBUG: ver qué se está enviando
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    $.ajax({
        url: urlweb + "api/Evento/guardar_evento",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            cambiar_estado_boton('idbtnguardar_evento', 'Guardando...', true);
        },
        success: function (r) {
            let data = JSON.parse(r); // 👈 convierte string a objeto
            cambiar_estado_boton('idbtnguardar_evento', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            respuesta(data.result.message, data.result.success ? "success" : "error");

            if (data.result.success) {
                $("#idmodalnuevoeventoCenter").modal("hide");
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr, status, error) {
            cambiar_estado_boton('idbtnguardar_evento', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            alert("Hubo un error al guardar el beneficio.");
        }
    });
}

function eliminar_evento(idevento){
    $.ajax({
        type: "POST",
        url: urlweb + "api/Evento/eliminar_evento",
        data: {
            idevento: idevento
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
            console.error("Error en la petición eliminar_evento: ", xhr.responseText);
        }
    });
}

function limpiar_formularioevento(){
    $("#evento_nombre").val("");
    $("#evento_fecha").val("");
    $("#idmodalnuevoeventoCenterLabel").text("Nuevo Evento");
}

function almacenareditar_formularioevento(id, nombre, fecha, estado) {
    // Convertir "YYYY-MM-DD HH:MM:SS" -> "YYYY-MM-DDTHH:MM"
    let f = fecha.replace(" ", "T").slice(0, 16);

    $("#idevento").val(id);
    $("#evento_nombre").val(nombre);
    $("#evento_fecha").val(f);
    $("#evento_estado").val(estado);
    $("#idmodalnuevoeventoCenterLabel").text("Editar Evento");
}
