function editar_estado_notificacion_interno(person){
    let guardarid = person;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Notificaciones/editar_notificacion_interno",
        data: {
            guardarid :guardarid
        },
        dataType: 'json'
    }).done(function(r){

    });
}
function mostrar_notificaciones() {
    var numNoti = document.getElementById("num_noti");
    var dropdownMenu = document.querySelector(".dropdown-menu");

    numNoti.style.display = "none";
    dropdownMenu.style.display = "block";

    // Agrega un evento de clic al documento para cerrar el menú si se hace clic fuera de él
    document.addEventListener("click", function (event) {
        if (!document.getElementById("notificationLink").contains(event.target) && !numNoti.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });
}
function icono_(id_noti){
    var id_ = id_noti;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Notificaciones/buscar_tareas",
        data: {
            id_ :id_
        },
        dataType: 'json'
    }).done(function(r){
        console.log(r);
        let tareas = r.result.tareas;
        let proyectos = r.result.proyectos;
        if(tareas){
            if(tareas.descripcion_detalletarea){
                $('#contenido_x_icono').html('Tarea: ' + tareas.nombre_tarea + '<br>' + 'Descripción: ' + tareas.descripcion_detalletarea);
            }else{
                $('#contenido_x_icono').html('Tarea: ' + tareas.nombre_tarea);
            }
        }else if(proyectos){
            $('#contenido_x_icono').html('Proyecto: ' + proyectos.proyecto_nombre);
        }else{
            $('#contenido_x_icono').html('Sin detalles');
        }
    });
}

function ver_mas() {
    mas = mas + 20;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Notificaciones/notificaciones_ver_mas",
        data: {
            mas : mas
        },
        dataType: 'json',
    }).done(function(r){
        console.log(r);
        let data_d = r.result.data_d;
        let data_h = r.result.data_h;
        let data_id = r.result.data_id;
        console.log(data_d);
        console.log(data_h);
        console.log(data_id);
        let body1 = "";
        let a = 1;
        if (data_d.length > 0 && data_h.length > 0) {
            for (let i = 0; i < data_d.length; i++) {
                body1 += `
            <tr>
                <td>${a}</td>
                <td>${data_d[i]}</td>
                <td>${data_h[i]}</td>
                <td><i onclick="icono_(${data_id[i]})" data-toggle="modal" data-target="#informacion" class="fa-solid fa-circle-info info-icon" style="color: #005eff;"></i></td>
            </tr>
        `;
                a++;
            }
        }

        $('#veinte_mas').html(body1);
    });
}



