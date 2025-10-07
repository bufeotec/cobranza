const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

let idcategoriabeneficio = 0;
let idcatregoriaseleccionado = 0;
let idbeneficio = 0;

function guardar_categoriabeneficio($btn) {
    let cant = $("#idinputcantidad").val();
    idbeneficio = $btn.closest('.modal').data('idbeneficio');

    if(cant === "0"){
        respuesta("agregar la cantidad", "error");
        return;
    }

    $.ajax({
        type: "POST",
        url: urlweb + "api/Beneficios/guardar_categoriabeneficio",
        data: {
            idcategoriabeneficio: idcategoriabeneficio,
            idbeneficio : idbeneficio,
            idcategoria : idcatregoriaseleccionado,
            cant : cant,
            fecha: fechaLocal
        },
        dataType: "json",
        beforeSend: function () {
            cambiar_estado_boton('idbtnguardar_categoriabeneficio', 'Guardando...', true);
        },
        success: function (r) {
            cambiar_estado_boton('idbtnguardar_categoriabeneficio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            respuesta(r.result.message, r.result.success ? "success" : "error");

            if (r.result.success) {
                const $modal = $btn.closest('.modal');
                const modalInstance = bootstrap.Modal.getInstance($modal[0]);
                modalInstance.hide();
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr) {
            cambiar_estado_boton('idbtnguardar_categoriabeneficio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            console.error("Error en la petición:", xhr.responseText);
        }
    });
}

function eliminar_categoriabeneficio(id_categoriabeneficio){
    $.ajax({
        type: "POST",
        url: urlweb + "api/Beneficios/eliminar_categoriabeneficio",
        data: {
            idcategoriabeneficio: id_categoriabeneficio
        },
        dataType: "json",
        beforeSend: function () {
            Swal.fire({
                title: 'Eliminado Categoría...',
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

function onchange_selectcategoria(select) {
    // obtengo el option seleccionado
    const selectedOption = $(select).find("option:selected");
    idcatregoriaseleccionado = selectedOption.val();

    // leo el atributo data-service
    const categoria = JSON.parse(selectedOption.attr("data-service"));
    $("#idlableprecionormal").text(`S/. ${categoria.categoria_cuota_anual}`);
    $("#idlablepreciosocio").text(`S/. ${categoria.categoria_cuota}`);
}

function almacenareditar_categoriabeneficio(idcategoriabeneficio_sele, idcategoria, cantidad){
    $('#idinputcantidad').val(cantidad);
    $('#idselectcategoria').val(idcategoria);
    idcatregoriaseleccionado = idcategoria;
    idcategoriabeneficio = idcategoriabeneficio_sele;
}

function limpiar_inputsmodal(){
    $('#idinputcantidad').val(0);
    $('#idselectcategoria').val(1);
}

