function guardar(){
    var valor = true;
    //Extraemos las variable según los valores del campo consultado
    var cliente_nombre = $('#cliente_nombre').val();
    var cliente_direccion = $('#cliente_direccion').val();
    var cliente_telefono = $('#cliente_telefono').val();
    var cliente_correo = $('#cliente_correo').val();
    var cliente_numero = $('#cliente_numero').val();
    var cliente_razonsocial = $('#cliente_razonsocial').val();
    var id_tipodocumento = $('#id_tipo_documento').val();

    //Validamos si los campos a usar no se encuentran vacios
    //valor = validar_campo_vacio('cliente_nombre', cliente_nombre, valor);


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-agregar";
        var cadena = "cliente_razonsocial=" + cliente_razonsocial +
            "&cliente_nombre=" + cliente_nombre +
            "&id_tipodocumento=" + id_tipodocumento +
            "&cliente_numero=" + cliente_numero +
            "&cliente_correo=" + cliente_correo +
            "&cliente_direccion=" + cliente_direccion +
            "&cliente_telefono=" + cliente_telefono;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Clientes/guardar_cliente",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Guardando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Guardando...", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cliente Agregado Exitosamente...Recargando!!!', 'success');
                        setTimeout(function () {
                            location.href = urlweb + 'Clientes/listar';
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al agregar cliente', 'error');
                        break;
                    case 5:
                        respuesta('El DNI o RUC ya se encuentra registrado', 'error');
                        $('#cliente_numero').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function guardar_editar(){
    var valor = true;
    //Extraemos las variable según los valores del campo consultado
    var cliente_nombre = $('#cliente_nombre').val();
    var cliente_direccion = $('#cliente_direccion').val();
    var cliente_telefono = $('#cliente_telefono').val();
    var cliente_correo = $('#cliente_correo').val();
    var cliente_numero = $('#cliente_numero').val();
    var cliente_razonsocial = $('#cliente_razonsocial').val();
    var id_tipodocumento = $('#id_tipo_documento').val();
    var id_cliente = $('#id_cliente').val();

    //Validamos si los campos a usar no se encuentran vacios
    //valor = validar_campo_vacio('cliente_nombre', cliente_nombre, valor);


    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Definimos el mensaje y boton a afectar
        var boton = "btn-agregar";
        var cadena = "cliente_razonsocial=" + cliente_razonsocial +
            "&cliente_nombre=" + cliente_nombre +
            "&id_tipodocumento=" + id_tipodocumento +
            "&id_cliente=" + id_cliente +
            "&cliente_numero=" + cliente_numero +
            "&cliente_correo=" + cliente_correo +
            "&cliente_direccion=" + cliente_direccion +
            "&cliente_telefono=" + cliente_telefono;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Clientes/guardar_cliente",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Guardando...", true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "Guardando...", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Cliente Agregado Exitosamente...Recargando!!!', 'success');
                        setTimeout(function () {
                            location.href = urlweb + 'Clientes/listar';
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al agregar cliente', 'error');
                        break;
                    case 5:
                        respuesta('El DNI o RUC ya se encuentra registrado', 'error');
                        $('#cliente_numero').css('border','solid red');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}

function eliminarcliente(id_cliente, boton) {
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    if(valor) {
        var cadena = "id_cliente=" + id_cliente;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Clientes/eliminar_cliente",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success: function (r) {
                cambiar_estado_boton(boton, "Eliminar Registro", false);
                switch (r.result.code) {
                    case 1:
                        $('#cliente' + id_cliente).remove();
                        respuesta('¡Cliente Eliminado!', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al eliminar Cliente', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}


function cambiar_estado(id_cliente){

    var cadena = "id_cliente=" + id_cliente;

    $.ajax({
        type:"POST",
        url: urlweb + "api/Clientes/cambiar_estado_cliente",
        data : cadena,
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Eliminado Exitosamente! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al cambiar estado, vuelva a intentarlo', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}
