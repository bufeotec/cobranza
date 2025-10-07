const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

function toggleAnulada(button) {
    let fila = button.closest("tr");
    fila.classList.toggle("anulada");
}

function agreagrcheck_eventoasit(ideventoasist, idsocio){
    //Obtengo él, Id de la URl
    let path = window.location.pathname;
    let partes = path.split("/");
    let idevento = partes[partes.length - 1];

    $.ajax({
        type: "POST",
        url: urlweb + "api/Evento/guardar_eventoasit",
        data: {
            ideventoasist : ideventoasist,
            idsocio: idsocio,
            idevento: idevento,
            fecha: fechaLocal
        },
        dataType: "json",
        beforeSend: function () {
            Swal.fire({
                title: 'Guardando...',
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