var urlweb = "http://127.0.0.1/cobranza/";
var ruta_web = "http://127.0.0.1/cobranza/";
//var ruta_web = "http://localhost/eggPHP3/";

//Función que hizo Carlitos que no sé bien para que sirve pero la dejo ahí por si las moscas
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
//Llamar así: onchange="return validar_correo(this.id)"
function validar_correo(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    if(expreg.test(text)){
        return true;
    } else {
        error("Formato de Correo Inválido");
        document.getElementById(id).value = '';
        return false;
    }
}

//Llamar así: onchange="return validar_solo_texto(this.id)"
function validar_solo_texto(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/);
    if(expreg.test(text)){
        return true;
    } else {
        error("El texto contiene carácteres no válidos.");
        document.getElementById(id).value = '';
        return false;
    }
}
//Función para que todo el texto de un cuadro sea en mayuscula
//Llamar así: onkeyup="mayuscula(this.id)"
function mayuscula(id) {
    var texto = document.getElementById(id).value;
    document.getElementById(id).value = texto.toUpperCase();
}
//Función para validar que sólo se ingresen 2 numeros decimales en un campo numerico
//Llamar así: onkeyup="return validar_numeros_decimales_dos(this.id)"
function validar_numeros_decimales_dos(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^[+-]?[0-9]*$/);
    var expreg2 = new RegExp(/^[+-]?[0-9]+([.]+)?$/);
    var expreg3 = new RegExp(/^[+-]?[0-9]+([.][0-9]{1,3})?$/);
    if(expreg.test(text)){
        return true;
    } else {
        if(expreg2.test(text)){
            return true;
        } else {
            if (expreg3.test(text)){
                return true;
            } else {
                //alertify.error("Carácter Inválido");
                var re = /[a-zA-ZñáéíóúÁÉÍÓÚ´,*+?^$&!¡¿#%/{}()='|[\]\\"]/g;
                document.getElementById(id).value = text.replace(re, '');
                text = document.getElementById(id).value;
                var long1 = text.length;
                var count = 1;
                if(long1 !== 0){
                    while (!expreg3.test(text)){
                        if(count !== 5){
                            var long = text.length;
                            var text_to_extract = long - 1;
                            document.getElementById(id).value = text.substring(0, text_to_extract);
                            text = document.getElementById(id).value;
                            count++;
                        } else {
                            document.getElementById(id).value = '0';
                            return false;
                        }
                    }
                }
                return false;
            }
        }

    }
}
//Función para validar que sólo se ingresen números en un campo de texto
//Llamar así: onkeyup="return validar_numeros(this.id)"
function validar_numeros(id) {
    var text = document.getElementById(id).value;
    var expreg = new RegExp(/^[0-9]*$/);
    if(expreg.test(text)){
        return true;
    } else {
        //alertify.error("Carácter Inválido");
        //var long = text.length;
        //var text_to_extract = long - 1;
        //document.getElementById(id).value = text.substring(0, text_to_extract);
        var re = /[a-zA-ZñáéíóúÁÉÍÓÚ´.*+?^$&!¡¿#%/{}()='|[\]\\"]/g;
        document.getElementById(id).value = text.replace(re, '');
        return false;
    }
}
//Función para validar campos vacios
function validar_campo_vacio(campo, valor, estado) {
    //var variable = "#" + campo;
    var objeto = document.getElementById(campo);
    if(valor == ""){
        respuesta('El siguiente Campo Resaltado no puede estar vacío', 'error');
        objeto.style.border = 'solid #ff4d4d';
        estado = false;
        console.log('Campo vacio: ' + campo + " Valor: " + valor);
    } else {
        objeto.style.border = '';
    }
    return estado;
}
//Función para validar parametros vacios
function validar_parametro_vacio(valor, estado) {
    if(valor === ""){
        estado = false;
        respuesta('Parametro vacío', 'error');
    }
    return estado;
}
//Función para redondear decimales
function redondear (numero, decimales = 2, usarComa = false) {
    //Esta respuesta
    var opciones = {
        maximumFractionDigits: decimales,
        useGrouping: false
    };
    return new Intl.NumberFormat((usarComa ? "es" : "en"), opciones).format(numero);
}
//Funcion para jugar con el color de un estado
function cambiar_color_estado(id) {
    var select_pe = $("#" + id).val();
    if (select_pe !== ""){
        switch (select_pe) {
            case '1':
                $("#" + id).css('color','white');
                $("#" + id).css('background','#17a673');
                break;
            case '0':
                $("#" + id).css('color','white');
                $("#" + id).css('background','#e74a3b');
                break;
        }
    }
}
//Función para cambiar el encabezado de un formulario
function cambiar_texto_formulario(id, texto){
    $("#" + id).html(texto);
}
//Función para deshabilitar o habilitar un botón
function cambiar_estado_boton(id, texto, deshabilitado){
    $("#" + id).html(texto);
    $("#" + id).attr("disabled", deshabilitado);
}
//Funcion para cambiar el estado y texto de una etiqueta
function colocar_estado_texto(estado, elemento, texto_si, texto_no){
    if(estado == 1){
        $('#' + elemento).removeClass('texto-deshabilitado');
        $('#' + elemento).addClass('texto-habilitado');
        $('#' + elemento).html(texto_si);
    } else {
        $('#' + elemento).removeClass('texto-habilitado');
        $('#' + elemento).addClass('texto-deshabilitado');
        $('#' + elemento).html(texto_no);
    }
}

$.ajaxSetup({
    beforeSend: function () {
        $("<div class='loader' id='loading'></div>").appendTo("body");
    },complete:function() {
        $("#loading").remove();
    }
});

function consultarNumdocumentoAPIV2_simple(valorNum) {
    let identifador = "";

    if (valorNum.length === 11) {
        identifador = "ruc";
    } else if (valorNum.length === 8) {
        identifador = "dni";
    } else {
        return $.Deferred().reject("Solo se aceptan cantidades de 11 y 8 dígitos").promise();
    }

    return $.ajax({
        url: `https://api.migo.pe/api/v1/${identifador}`,
        method: "POST",
        data: {
            token: "uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m",
            [identifador]: valorNum
        },
        dataType: "json"
    }).then(function (data) {
        if (!data.success) {
            return $.Deferred().reject("No se encontró información").promise();
        }

        let result = {
            nombre: identifador === "ruc" ? data.nombre_o_razon_social : data.nombre,
            direccion: identifador === "ruc" ? data.condicion_de_domicilio : ""
        };

        return [result]; // devuelve array con el objeto
    });
}


function consultarNumdocumentoAPI(DocumentType, idValue, customerName = null , customerAddress= null,clientStatus = null, nombreVENTAWEB = null){
    // nombreVENTAWEB se agregó nomas para que funcione en la página web
    var tipoDocumento= "";
    var valorNum = "";
    var tipoRespuesta = "";
    if(DocumentType){
        if (!isNaN(DocumentType)){
            tipoDocumento = DocumentType;
        }else{
            tipoDocumento = $('#'+DocumentType).val();
        }
    }
    if(idValue){
        if (typeof idValue === 'string' && idValue.length > 2) {
            // Es un ID de elemento
            valorNum = $('#' + idValue).val();
        } else {
            // Es un valor directo
            valorNum = idValue;
        }
    }
    if (clientStatus){
        $('#'+clientStatus).html("");
    }
    // verificamos que tipo de documento es
    respuesta('Buscando....', 'info');

    if(tipoDocumento == 4){
        if(valorNum.length === 11){
            if (!isNaN(valorNum)){
                if(valorNum=="00000000000"){
                    respuesta('Proveedor Extranjero', 'success');
                    tipoRespuesta = "text-success";
                    $('#'+clientStatus).html("HABIDO");
                }else{
                    let formData = new FormData();
                    formData.append("token", "uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
                    formData.append("ruc", valorNum);
                    let request = new XMLHttpRequest();
                    request.open("POST", "https://api.migo.pe/api/v1/ruc");
                    request.setRequestHeader("Accept", "application/json");
                    request.send(formData);
                    $('.loader').show();
                    request.onload = function() {
                        var data = JSON.parse(this.response);
                        if(data.success){
                            $('.loader').hide();
                            respuesta('Datos Encontrados', 'success');
                            if(data.condicion_de_domicilio=="NO HABIDO"){
                                respuesta('Este ruc se encuentra como NO HABIDO.', 'error');
                                tipoRespuesta = "text-danger";
                            }else{
                                $('#'+customerName).val(data.nombre_o_razon_social);
                                $('#'+customerAddress).val(data.direccion);
                                tipoRespuesta = "text-success";
                            }
                            if (clientStatus){
                                $('#'+clientStatus).html(data.condicion_de_domicilio);
                                $('#'+clientStatus).addClass(tipoRespuesta);
                            }


                        }else{
                            $('.loader').hide();
                            respuesta(data.message, 'error');
                        }
                    };
                }
            }else{
                respuesta('El ruc debe contener solo números.', 'error');
                $('#'+clientStatus).html("");
            }
        }else{
            respuesta('El ruc debe contener 11 dígitos.', 'error');
            $('#'+clientStatus).html("");
        }
    }
    else{
        if(valorNum.length === 8){
            if (!isNaN(valorNum)){
                if(valorNum=="00000000"){
                    respuesta('CLIENTE GENERAL', 'success');
                    $('#'+clientStatus).html("HABIDO");
                }else{
                    let formData = new FormData();
                    formData.append("token", "uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
                    formData.append("dni", valorNum);
                    let request = new XMLHttpRequest();
                    request.open("POST", "https://api.migo.pe/api/v1/dni");
                    request.setRequestHeader("Accept", "application/json");
                    request.send(formData);
                    $('.loader').show();
                    request.onload = function() {
                        var data = JSON.parse(this.response);
                        if(data.success){
                            $('.loader').hide();
                            console.log(data)
                            tipoRespuesta = "text-success";
                            respuesta('Datos Encontrados', 'success');
                            $('#'+customerName).val(data.nombre);
                            if(customerAddress){
                                $('#'+customerAddress).val("");
                            }
                            // solo sirve para la web ya que ahi se tiene que visualizar en un card el nombre del cliente
                            if (clientStatus){
                                $('#'+clientStatus).html("HABIDO");
                                $('#'+clientStatus).addClass(tipoRespuesta);
                            }
                            if(nombreVENTAWEB){
                                $('#'+nombreVENTAWEB).html(data.nombre+" - HABIDO");
                            }


                        }else{
                            $('.loader').hide();
                            tipoRespuesta = "text-danger";
                            respuesta(data.message, 'error');
                            if (clientStatus){
                                $('#'+clientStatus).addClass(tipoRespuesta);
                            }
                        }
                    };
                }
            }else{
                respuesta('El DNI debe contener solo números.', 'error');
                $('#'+clientStatus).html("");
            }
        }else{
            respuesta('El DNI debe contener 8 dígitos.', 'error');
            $('#'+clientStatus).html("");
        }
    }
}