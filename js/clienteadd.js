const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

function guardar_cliente(formData){
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

// 🔹 Función para llenar un select dinámicamente con AJAX
function cargarselect_tipodocumento() {
    $.ajax({
        url: urlweb + "api/TipoDocumento/selecttipodocumentos",
        type: "GET",
        dataType: "json",
        success: function (response) {
            // limpiar opciones actuales
            $("#id_tipodocumento").empty();
            $("#id_tipodocumento").append('<option value="">Seleccione una opción</option>');

            // recorrer datos (dentro de response.data)
            $.each(response.data, function (i, item) {
                $("#id_tipodocumento").append(
                    `<option value="${item.id_tipodocumento}">
                        ${item.tipodocumento_abreviado}
                    </option>`
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar datos:", error);
        }
    });
}

