<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 2/09/2025
 * Time: 12:38
 */
?>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
    </div>

    <hr>
    <div class="row">
        <?php
        // Esta vista solo imprime DENTRO del <div class="row"> del layout global.
        ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Generar Cobranza</h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="id_categoria_socio">Categoría de Cobro</label>
                            <select class="form-control" id="id_categoria_socio">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat->id_categoria; ?>" <?php if($id_categoria_socio == $cat->id_categoria) { echo 'selected';} ?> ><?= $cat->categoria_nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="mes">Mes a facturar</label>
                            <select class="form-control" id="mes">
                                <option value="" <?php if($mes == "") { echo 'selected';} ?> >-- Mes --</option>
                                <option value="1" <?php if($mes == "1") { echo 'selected';} ?> >Enero</option>
                                <option value="2" <?php if($mes == "2") { echo 'selected';} ?> >Febrero</option>
                                <option value="3" <?php if($mes == "3") { echo 'selected';} ?> >Marzo</option>
                                <option value="4" <?php if($mes == "4") { echo 'selected';} ?> >Abril</option>
                                <option value="5" <?php if($mes == "5") { echo 'selected';} ?> >Mayo</option>
                                <option value="6" <?php if($mes == "6") { echo 'selected';} ?> >Junio</option>
                                <option value="7" <?php if($mes == "7") { echo 'selected';} ?> >Julio</option>
                                <option value="8" <?php if($mes == "8") { echo 'selected';} ?> >Agosto</option>
                                <option value="9" <?php if($mes == "9") { echo 'selected';} ?> >Septiembre</option>
                                <option value="10" <?php if($mes == "10") { echo 'selected';} ?> >Octubre</option>
                                <option value="11" <?php if($mes == "11") { echo 'selected';} ?> >Noviembre</option>
                                <option value="12" <?php if($mes == "12") { echo 'selected';} ?> >Diciembre</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="anio">Año</label>
                            <input type="number" class="form-control" id="anio" placeholder="YYYY" value="<?= $anio; ?>" min="2000" max="2100">
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary" onclick="consultar_cobranza();">
                            Consultar
                        </button>
                        <?php
                        if($facturar){
                            ?>
                            <button class="btn btn-success" id="btn-generar" onclick="generar_cobranza();">
                                Generar
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if($facturar){
            ?>
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="dataTable66">
                    <thead>
                    <tr>
                        <th style="width: 50px;">N°</th>
                        <th>Cliente</th>
                        <th style="width: 150px;">Facturar?</th>
                        <th>Tipo de Pago</th>
                        <th>Forma de Pago</th>
                        <th>Descripción Particular</th>
                        <th style="width: 150px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach($clientes as $c){
                        $_SESSION['pagos'][$c->id_socio] = array(
                            "id_socio" => $c->id_socio,
                            "id_cliente" => $c->id_cliente,
                            "tipo_pago" => "3",
                            "forma_pago" => "2",
                            "descripcion" => "",
                            "cobrar" => 1
                        );
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $c->cliente_razonsocial; ?></td>
                            <td>
                                <select class="form-control facturar-opcion readonly_select" data-id="<?= $c->id_socio; ?>" id="generar_cobrito_<?= $c->id_socio; ?>">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control facturar-opcion readonly_select"  id="tipo_paguito_<?= $c->id_socio; ?>">
                                    <option value="1">TARJETA</option>
                                    <option value="2">TRANSFERENCIA</option>
                                    <option value="3" selected>EFECTIVO</option>
                                    <option value="6">YAPE / PLIN</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control facturar-opcion readonly_select"  id="forma_paguito_<?= $c->id_socio; ?>">
                                    <option value="1">CONTADO</option>
                                    <option value="2" selected>CREDITO</option>
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control facturar-opcion readonly_select"  id="descripcion_<?= $c->id_socio; ?>" cols="12" rows="3"></textarea>
                            </td>
                            <td>
                                <a onclick="editar_cobrito(<?= $c->id_socio; ?>)" id="btn_editar_<?= $c->id_socio; ?>" data-toggle="tooltip" title='Editar'>
                                    <i class='fa fa-edit text-success editar margen'></i>
                                </a>
                                <a onclick="actualizar_cobrito(<?= $c->id_socio; ?>)" class="no-show" style="font-size: 18px;" id="btn_actualizar_<?= $c->id_socio; ?>" data-toggle="tooltip" title='Guardar'>
                                    <i class='fa fa-check text-primary margen'></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--EndQ of Main Content-->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>cobranza.js"></script>
<script>
    // Opcional: enfocar primer campo
    setTimeout(function(){ document.getElementById('id_categoria_socio').focus(); }, 200);

    function consultar_cobranza(){
        var id_categoria_socio = $('#id_categoria_socio').val();
        var mes = $('#mes').val();
        var anio = $('#anio').val();
        var ok = true;

        if(id_categoria_socio === "" || id_categoria_socio === null){ ok = false; respuesta("Seleccione una categoría", 'error'); }
        if(mes === "" || mes === null){ ok = false; respuesta("Seleccione un mes", 'error'); }
        if(anio === "" || anio === null){ ok = false; respuesta("Ingrese un año", 'error'); }

        if(ok){
            let ruta = urlweb + "index.php?c=Cobranza&a=cobranza&id_categoria_socio=" + id_categoria_socio + "&mes=" + mes + "&anio=" + anio;
            location.href = ruta;
        }
    }

    function generar_cobranza(){
        var boton = "btn-generar";
        var id_categoria_socio = $('#id_categoria_socio').val();
        var mes = $('#mes').val();
        var anio = $('#anio').val();
        var ok = true;

        if(id_categoria_socio === "" || id_categoria_socio === null){ ok = false; respuesta("Seleccione una categoría", 'error'); }
        if(mes === "" || mes === null){ ok = false; respuesta("Seleccione un mes", 'error'); }
        if(anio === "" || anio === null){ ok = false; respuesta("Ingrese un año", 'error'); }

        if(ok){
            var cadena = "id_categoria_socio=" + encodeURIComponent(id_categoria_socio) +
                "&mes=" + encodeURIComponent(mes) +
                "&anio=" + encodeURIComponent(anio);
            $.ajax({
                type: "POST",
                url: urlweb + "api/Cobranza/generar_cobranza",
                data: cadena,
                dataType: 'json',
                beforeSend: function(){
                    $("#" + boton).html("Generando...").attr("disabled", true);
                },
                success: function(r){
                    $("#" + boton).attr("disabled", false).html("Generar");
                    switch (r.result.code) {
                        case 1:
                            respuesta(r.result.message || "¡Cobranza generada!", 'success');
                            // Redirige a un listado o dashboard de cobranza si lo tienes
                            setTimeout(function(){ location.href = urlweb + "cobranza/listar"; }, 300);
                            break;
                        case 2:
                            respuesta(r.result.message || "Fallo en el proceso", 'error');
                            break;
                        case 6:
                            respuesta(r.result.message || "Integridad de datos falló", 'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO", 'error');
                    }
                },
                error: function(){
                    $("#" + boton).attr("disabled", false).html("Generar");
                    respuesta("Error de comunicación", 'error');
                }
            });
        }
    }

</script>