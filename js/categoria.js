//Se usa para agregar un nuevo menú al sistema
function gestionar_categoria(){
    var valor = true;
    var boton = "btn-agregar-categoria";
    var id_categoria = $('#id_categoria').val();

    var categoria_nombre = $('#categoria_nombre').val();
    var categoria_cuota = $('#categoria_cuota').val();
    var categoria_inscripcion = $('#categoria_inscripcion').val();
    var categoria_cuota_anual = $('#categoria_cuota_anual').val();
    var categoria_horas_auditorio = $('#categoria_horas_auditorio').val();
    var categoria_estado = $('#categoria_estado').val();
    valor = validar_campo_vacio('categoria_nombre', categoria_nombre, valor);
    valor = validar_campo_vacio('categoria_cuota', categoria_cuota, valor);
    valor = validar_campo_vacio('categoria_inscripcion', categoria_inscripcion, valor);
    valor = validar_campo_vacio('categoria_cuota_anual', categoria_cuota_anual, valor);
    valor = validar_campo_vacio('categoria_horas_auditorio', categoria_horas_auditorio, valor);
    valor = validar_campo_vacio('categoria_estado', categoria_estado, valor);
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        var cadena = "categoria_nombre=" + categoria_nombre +
            "&categoria_cuota=" + categoria_cuota +
            "&categoria_inscripcion=" + categoria_inscripcion +
            "&categoria_cuota_anual=" + categoria_cuota_anual +
            "&categoria_horas_auditorio=" + categoria_horas_auditorio +
            "&categoria_estado=" + categoria_estado +
            "&id_categoria=" + id_categoria;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Categorias/guardar_categoria",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        if(id_categoria != ""){
                            respuesta('¡Categoria Editada Exitosamente', 'success');
                            setTimeout(function () {location.reload();}, 1000);
                        } else {
                            respuesta('¡Categoria guardado! Recargando...', 'success');
                            setTimeout(function () {location.reload();}, 1000);
                        }
                        break;
                    case 2:
                        respuesta(r.result.message, 'error');
                        break;
                    case 3:
                        respuesta('La categoria ya se encuentra registrado', 'error');
                        break;
                    default:
                        respuesta('¡Ocurrió un error inesperado!', 'error');
                        break;
                }
            }
        });
    }
}
function edicion_categoria(id_categoria, categoria_nombre, categoria_cuota,categoria_inscripcion, categoria_cuota_anual, categoria_horas_auditorio, categoria_estado){
    $('#id_categoria').val(id_categoria);
    $('#categoria_nombre').val(categoria_nombre);
    $('#categoria_cuota').val(categoria_cuota);
    $('#categoria_inscripcion').val(categoria_inscripcion);
    $('#categoria_cuota_anual').val(categoria_cuota_anual);
    $('#categoria_horas_auditorio').val(categoria_horas_auditorio);
    $('#categoria_estado').val(categoria_estado);
    cambiar_color_estado('categoria_estado');
}
function agregacion_categoria(){
    $('#id_categoria').val("");
    $('#categoria_cuota_anual').val("");
    $('#categoria_nombre').val("");
    $('#categoria_cuota').val("");
    $('#categoria_inscripcion').val("");
    $('#categoria_horas_auditorio').val("");
    $("#categoria_estado").css('color','white');
    $("#categoria_estado").css('background','#17a673');
}
