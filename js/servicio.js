//Se usa para agregar un nuevo menú al sistema
function gestionar_servicio(){
    var valor = true;
    var boton = "btn-agregar-servicio";
    var id_servicio = $('#id_servicio').val();
    var id_servicios_categoria = $('#id_servicios_categoria').val();
    let id_servicio_tipo_afectacion = $("#id_servicio_tipo_afectacion").val();

    var servicio_nombre = $('#servicio_nombre').val();
    var servicio_descripcion = $('#servicio_descripcion').val();
    var servicio_precio_normal = $('#servicio_precio_normal').val();
    var servicio_precio_socio = $('#servicio_precio_socio').val();
    var servicio_estado = $('#servicio_estado').val();
    valor = validar_campo_vacio('servicio_nombre', servicio_nombre, valor);
    valor = validar_campo_vacio('id_servicios_categoria', id_servicios_categoria, valor);
    valor = validar_campo_vacio('servicio_descripcion', servicio_descripcion, valor);
    valor = validar_campo_vacio('servicio_precio_normal', servicio_precio_normal, valor);
    valor = validar_campo_vacio('servicio_precio_socio', servicio_precio_socio, valor);
    valor = validar_campo_vacio('servicio_estado', servicio_estado, valor);
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "servicio_nombre=" + servicio_nombre +
            "&servicio_descripcion=" + servicio_descripcion +
            "&id_servicios_categoria=" + id_servicios_categoria +
            "&servicio_precio_normal=" + servicio_precio_normal +
            "&servicio_precio_socio=" + servicio_precio_socio +
            "&servicio_estado=" + servicio_estado +
            "&id_servicio=" + id_servicio +
            "&id_servicio_tipo_afectacion=" + id_servicio_tipo_afectacion;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Servicios/guardar_servicio",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        if(id_servicio != ""){
                            respuesta('¡Servicio Editado Exitosamente', 'success');
                            $('#servicionombre' + id_servicio).html(r.result.servicio.servicio_nombre);
                            $('#serviciodesc' + id_servicio).html(r.result.servicio.servicio_descripcion);
                            $('#serviciocat' + id_servicio).html(r.result.servicio.id_servicios_categoria);
                            $('#servicioprecn' + id_servicio).html(r.result.servicio.servicio_precio_normal);
                            $('#servicioprecs' + id_servicio).html(r.result.servicio.servicio_precio_socio);
                            $('#botonmenu' + id_servicio).html("<button data-toggle=\"modal\" data-target=\"#gestionServicio\" class=\"btn btn-sm btn-warning btne\" onclick=\"cambiar_texto_formulario('exampleModalLabel', 'Editar Servicio'); edicion_servicio(" + r.result.servicio.servicio_nombre + ", '" +r.result.servicio.servicio_descripcion+"', '"+r.result.servicio.id_servicios_categoria+"', '" + r.result.servicio.servicio_precio_normal + "', '" + r.result.servicio.servicio_precio_socio + ", " + r.result.servicio.servicio_estado + ")\" >Editar</button>");
                            colocar_estado_texto(r.result.servicio.servicio_estado, 'servicioestado' + id_servicio, 'HABILITADO', 'DESHABILITADO');
                            setTimeout(function () {location.reload();}, 1000);
                        } else {
                            respuesta('¡Servicio guardado! Recargando...', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        break;
                    case 2:
                        respuesta('Error al guardar servicio', 'error');
                        break;
                    case 3:
                        respuesta('El Servicio ya se encuentra registrado', 'error');
                        break;
                    default:
                        respuesta('¡Ocurrió un error inesperado!', 'error');
                        break;
                }
            }
        });
    }
}
function edicion_servicio(id_servicio, servicio_nombre, servicio_descripcion,id_servicios_categoria, servicio_precio_normal, servicio_precio_socio, servicio_estado, socio_tipoafectacion){
    $('#id_servicio').val(id_servicio);
    $('#id_servicios_categoria').val(id_servicios_categoria);
    $('#servicio_nombre').val(servicio_nombre);
    $('#servicio_descripcion').val(servicio_descripcion);
    $('#servicio_precio_normal').val(servicio_precio_normal);
    $('#servicio_precio_socio').val(servicio_precio_socio);
    $('#servicio_estado').val(servicio_estado);
    $('#id_servicio_tipo_afectacion').val(socio_tipoafectacion);
    cambiar_color_estado('servicio_estado');
}
function agregacion_servicio(){
    $('#id_servicio').val("");
    $('#id_servicios_categoria').val("");
    $('#servicio_nombre').val("");
    $('#servicio_descripcion').val("");
    $('#servicio_precio_normal').val("");
    $('#servicio_precio_socio').val("");
    $("#servicio_estado").css('color','white');
    $("#servicio_estado").css('background','#17a673');
}
