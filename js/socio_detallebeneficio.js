const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);
let usoactual;

function alimentarvaraibleslocales(usoactualp){
    usoactual = usoactualp;
    console.log(usoactual);
}

function limpiar_inputsmodal_vista_sociodetallebeneficio(){
    $('#idinputcantidad_vista_sociodetallebeneficio').val(0);
}

function validarbeneficiosuso(){
    let exito = false;
    let haynulo = false;
    let beneficioencontrado;
    let idbeneficio = $("#idselectbeneficio").val();
    let cant = $("#idinputcantidad_vista_sociodetallebeneficio").val();

    if (idbeneficio !== "0"){
        //recorro todo el array usoactual
        for(let i = 0; i < usoactual.length; i++) {
            if(i === 0 && usoactual[i]["id_beneficio"] === null){
                haynulo = true;
                break;
            } else if(usoactual[i]["id_beneficio"].toString().trim() === idbeneficio){
                beneficioencontrado = usoactual[i];
                break;
            }
        }

        if(haynulo){
            exito = true;
        }else if(beneficioencontrado === undefined) {
            exito = true;
        } else if (Number(cant) <= Number(beneficioencontrado.cantidad_restante)) {
            $("#idmensaje").hide();
            $("#idbtnguardar_beneficiousoSocio").prop("disabled", false); // habilitar
            exito = true;
        } else {
            $("#idmensaje").show();
            $("#idbtnguardar_beneficiousoSocio").prop("disabled", true); // deshabilitar
            exito = false;
        }
    }
    else{
        respuesta("Seleccione un Beneficio", "error");
    }

    return exito;
}

function registrar_usobeneficiosSocioBackend(){

    //Obtengo el IdSocio de la URL
    let path = window.location.pathname;
    let parts = path.split("/");
    let idsocio = parts[parts.length - 1]; // "2"

    let cant = $("#idinputcantidad_vista_sociodetallebeneficio").val();
    let idbeneficio = $("#idselectbeneficio").val();

    if(cant <= 0){
        respuesta("Agrega Mayor que cero", "error");
        return;
    }
    if(!validarbeneficiosuso()){
        return;
    }


    $.ajax({
        url: urlweb + "api/Beneficios/guardar_beneficiouso",
        type: "POST",
        data: {
            idsocio: idsocio,
            idbeneficio: idbeneficio,
            cant: cant,
            fecha: fechaLocal
        },
        beforeSend: function () {
            cambiar_estado_boton('idbtnguardar_beneficiousoSocio', 'Guardando...', true);
        },
        success: function (r) {
            let data = JSON.parse(r); // 👈 convierte string a objeto
            cambiar_estado_boton('idbtnguardar_beneficiousoSocio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            respuesta(data.result.message, data.result.success ? "success" : "error");

            if (data.result.success) {
                $("#idmodalagregarbeneficiosocio_vistadetallebeneficio").modal("hide");
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr, status, error) {
            cambiar_estado_boton('idbtnguardar_beneficiousoSocio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            alert("Hubo un error al guardar el beneficio.");
        }
    });
}

function eliminarMes(periodo) {
    if (!confirm('¿Eliminar todo el mes ' + periodo + '?')) return;
    console.log('Eliminar mes:', periodo);
}

function eliminarUsoBeneficio(id) {
    // if (!confirm('¿Eliminar registro #' + id + '?')) return;
    $.ajax({
        url: urlweb + "api/Beneficios/eliminar_beneficiouso",
        type: "POST",
        data: {
            idbeneficiouso: id,
        },
        beforeSend: function () {
            cambiar_estado_boton('idbtnguardar_beneficiousoSocio', 'Guardando...', true);
        },
        success: function (r) {
            let data = JSON.parse(r); // 👈 convierte string a objeto
            cambiar_estado_boton('idbtnguardar_beneficiousoSocio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            respuesta(data.result.message, data.result.success ? "success" : "error");

            if (data.result.success) {
                $("#idmodalagregarbeneficiosocio_vistadetallebeneficio").modal("hide");
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function (xhr, status, error) {
            cambiar_estado_boton('idbtnguardar_beneficiousoSocio', "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
            alert("Hubo un error al guardar el beneficio.");
        }
    });
}