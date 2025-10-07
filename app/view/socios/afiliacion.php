<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:12
 */
?>

<!-- Modal para los clientes -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Selecciona un Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <table id="dataTable2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th style="width: 200px;">Cliente</th>
                                <th>Num Documento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p->id_cliente) ?></td>
                                    <td><?= htmlspecialchars($p->cliente_nombre == "" ? $p->cliente_razonsocial : $p->cliente_nombre) ?></td>
                                    <td> <?= htmlspecialchars($p->cliente_numero) ?> </td>
                                    <td>
                                        <button
                                                onclick="seleccionar_Cliente_tablamodalCliente_vistacrearsocio($(this));"
                                                type="button"
                                                class="btn btn-success btn-xs"
                                                data-dismiss="modal"
                                                data-service='<?= json_encode($p, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'>
                                            <i class="fa fa-check-circle"></i> Elegir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">FICHA DE INGRESO DE ASOCIADOS</h6>
                </div>

                <div class="card-body">
                    <form class="row g-3" id="idformularioafiliado">
                        <input type="hidden" name="id_cliente" id="id_cliente" value="0">

                        <div class="col-md-5">
                            <label for="empresa_tipo" class="form-label">Tipo Persona</label>
                            <select class="form-select" id="empresa_tipo" name="empresa_tipo" onchange="onchange_selectTipoPersona($(this).val())" required>
                                <option disabled value="">Seleccione</option>
                                <option value="1">Persona Natural</option>
                                <option selected value="2">Persona Jurídica</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="empresa_ruc" class="form-label">Nro de RUC</label>
                            <input autofocus id="empresa_ruc"
                                   onchange="consultar_documento_vistacrearfilicacion(this.value)"
                                   name="empresa_ruc"
                                   class="form-control"
                                   type="text"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   maxlength="11"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                   required
                            >
                        </div>
                        <div class="col-lg-2">
                            <button style="width: 100%; margin-top: 33px" class="btn btn-success" type="button" data-toggle="modal" data-target="#largeModal"><i class="fa fa-search"></i> Buscar cliente</button>
                        </div>


                        <div class="col-md-12">
                            <label for="empresa_razonsocial" class="col-form-label">Razón Social</label>
                            <input class="form-control" type="text" id="empresa_razonsocial" maxlength="200" name="empresa_razonsocial" required>

                            <label for="empresa_direccion" class="col-form-label">Domicilio fiscal</label>
                            <input class="form-control" type="text" id="empresa_direccion" maxlength="500" name="empresa_direccion" required>

                            <label for="empresa_nombre" class="col-form-label">Nombre Comercial</label>
                            <input class="form-control" type="text" id="empresa_nombre" maxlength="200" name="empresa_nombre" required>
                        </div>

                        <div class="col-md-4">
                            <label for="selectDepartamento" class="col-form-label">Departamento</label>
                            <select id="selectDepartamento" name="selectDepartamento" onchange="cambia()"  class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="Amazonas">Amazonas</option>
                                <option value="Ancash">Ancash</option>
                                <option value="Apurímac">Apurímac</option>
                                <option value="Arequipa">Arequipa</option>
                                <option value="Ayacucho">Ayacucho</option>
                                <option value="Cajamarca">Cajamarca</option>
                                <option value="Callao">Callao</option>
                                <option value="Cuzco">Cuzco </option>
                                <option value="Huancavelica">Huancavelica</option>
                                <option value="Huánuco">Huánuco</option>
                                <option value="Ica">Ica</option>
                                <option value="Junín">Junín</option>
                                <option value="La_Libertad">La Libertad</option>
                                <option value="Lambayeque">Lambayeque</option>
                                <option value="Lima">Lima</option>
                                <option value="Loreto">Loreto</option>
                                <option value="Madre_de_Dios">Madre de Dios</option>
                                <option value="Moquegua">Moquegua</option>
                                <option value="Pasco">Pasco</option>
                                <option value="Piura">Piura</option>
                                <option value="Puno">Puno</option>
                                <option value="San_Martín">San Martín</option>
                                <option value="Tacna">Tacna</option>
                                <option value="Tumbes">Tumbes</option>
                                <option value="Ucayali">Ucayali</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="selectProvincia" class="col-form-label">Provincia</label>
                            <select class="form-control" id="selectProvincia" name="selectProvincia" onchange="cambiaDistrito()" required>
                                <option value="">Seleccione la Provincia</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="selectDistrito" class="col-form-label">Distrito</label>
                            <select class="form-control" id="selectDistrito" name="selectDistrito" required>
                                <option value="">Seleccione el Distrito</option>
                            </select>
                        </div>



                        <div class="col-md-4">
                            <label for="empresa_fundacion" class="col-form-label">Fecha de fundación</label>
                            <input class="form-control" type="date" id="empresa_fundacion" name="empresa_fundacion" required>
                        </div>
                        <div class="col-md-4">
                            <label for="id_sector" class="col-form-label">Sector</label>
                            <select class="form-control" id="id_sector" onchange="rubro_x_sector()" name="empresa_sector" required>
                                <option value="">Seleccione</option>
                                <?php
                                foreach ($sectores as $se) {
                                    echo "<option value='$se->id_sector'>$se->sector_nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="id_rubro" class="col-form-label">Rubro</label>
                            <select class="form-control" id="id_rubro" name="id_rubro" required></select>
                        </div>

                        <div class="col-md-12">
                            <label for="empresa_descripcion1" class="form-label">Breve descripción de la actividad de la empresa</label>
                            <textarea class="form-control" id="empresa_descripcion1" name="empresa_descripcion" required></textarea>
                        </div>


                        <div class="col-md-3">
                            <label for="empresa_telefono1" class="col-form-label">Teléfono 1</label>
                            <input class="form-control" id="empresa_telefono1" name="empresa_telefono1" maxlength="15"
                                   type="text"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            >
                        </div>
                        <div class="col-md-3">
                            <label for="empresa_telefono2" class="col-form-label">Teléfono 2</label>
                            <input class="form-control" id="empresa_telefono2" name="empresa_telefono2" maxlength="15"
                                   type="text"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            >
                        </div>
                        <div class="col-md-3">
                            <label for="empresa_celular1" class="col-form-label">Celular 1</label>
                            <input class="form-control" id="empresa_celular1" name="empresa_celular1" maxlength="9"
                                   type="text"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            >
                        </div>
                        <div class="col-md-3">
                            <label for="empresa_celular2" class="col-form-label">Celular 2</label>
                            <input class="form-control" id="empresa_celular2" name="empresa_celular2" maxlength="9"
                                   type="text"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="empresa_paginaweb" class="col-form-label">Página web</label>
                            <input class="form-control" type="text" id="empresa_paginaweb" name="empresa_paginaweb" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label for="empresa_email" class="col-form-label">Email</label>
                            <input class="form-control" type="text" id="empresa_email" name="empresa_email" maxlength="200">
                        </div>

                        <h6 class="mb-3 fw-bold">Principales Ejecutivos</h6>
                        <div class="col-md-6">
                            <label for="empresa_apellidos" class="col-form-label">Apellidos y Nombres</label>
                            <input class="form-control" type="text" id="empresa_apellidos" maxlength="200" name="empresa_apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label for="idinputcargoafiliado" class="col-form-label">Cargo</label>
                            <input class="form-control" type="text" id="idinputcargoafiliado" maxlength="100" name="idinputcargoafiliado" required>
                        </div>

                        <div class="col-md-6">
                            <label for="idinput_ornomasticoafiliado" class="col-form-label">Onomástico</label>
                            <input class="form-control" type="date" id="idinput_ornomasticoafiliado" maxlength="100" name="idinput_ornomasticoafiliado" required>
                        </div>
                        <div class="col-md-6">
                            <label for="idinput_emailejecutivo" class="col-form-label">Email</label>
                            <input class="form-control" type="email" id="idinput_emailejecutivo" maxlength="100" name="idinput_emailejecutivo" required>
                        </div>

                        <h6 class="mb-3 fw-bold">Actividades que realiza la Empresa</h6>
                        <div class="d-flex flex-wrap justify-content-center gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actividades[]" value="1" id="opcion1">
                                <label class="form-check-label" for="opcion1">Fabrica</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actividades[]" value="2" id="opcion2">
                                <label class="form-check-label" for="opcion2">Importa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actividades[]" value="3" id="idcheckbox">
                                <label class="form-check-label" for="idcheckbox">Exporta</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actividades[]" value="4" id="idcheckboxcomercio">
                                <label class="form-check-label" for="idcheckboxcomercio">Comercio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actividades[]" value="5" id="idcheckboxservicio">
                                <label class="form-check-label" for="idcheckboxservicio">Servicio</label>
                            </div>
                        </div>

                        <br><br>
                        <div class="col-md-3">
                            <label for="idselect_categoriaafiliado" class="form-label">Categoría</label>
                            <select class="form-control" id="idselect_categoriaafiliado" name="idselect_categoriaafiliado" required>
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cuota Mensual</label>
                            <input type="number" class="form-control" id="idinputcuotamensualafiliacion">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cuota de ingreso</label>
                            <input type="number" class="form-control" id="idinputcuotaingresoafiliacion">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Medio de pago</label>
                            <select id="idselecttipopago" name="idselecttipopago" class="form-control">
                                <option value="efectivo">Efectivo</option>
                                <option value="plin/yape">Plin / Yape</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>


                        <div class="col-md-12">
                            <h6 class="mb-3 fw-bold">
                                Adjunta los documentos
                                <span class="text-muted" id="idspan_documentos">(RUC, DNI, vigencia de poder, etc.)</span>
                            </h6>

                            <div class="row">
                                <!-- Documento 1 -->
                                <div class="col-md-6" id="idgrupo_ficharuc">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <!-- Label con icono al costado -->
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2" id="idlabel_ficharuc">
                                                Ficha RUC
                                                <span id="checkRUC" class="text-success" style="display: none">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>

                                            <div class="input-group">
                                                <input type="file" class="form-control" id="idinputRUC" accept="application/pdf" onchange="mostrarCheck_inputdocumento(this, '#checkRUC')">
                                                <button class="btn btn-outline-danger" type="button" id="idbotoneliminartRUC" onclick="borrarArchivo_inputdocumento('#idinputRUC', '#checkRUC')">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documento 2 -->
                                <div class="col-md-6" id="idgrupo_dni">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2" id="idlabel_DNI">
                                                Copia del DNI.
                                                <span id="check_DNI" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="idinputDNI" accept="application/pdf" onchange="mostrarCheck_inputdocumento(this, '#check_DNI')">
                                                <button class="btn btn-outline-danger" type="button" id="idbotoneliminar_DNI" onclick="borrarArchivo_inputdocumento('#idinputDNI', '#check_DNI')">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documento Ficha de inscripción -->
                                <div class="col-md-6">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2" id="idlabel_fichainscripcion">
                                                Ficha de inscripción firmada.
                                                <span id="check_fichainscripcion" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    onchange="mostrarCheck_inputdocumento(this, '#check_fichainscripcion')"
                                                    id="idinput_fichainscripcionfirmada"
                                                    accept="application/pdf"
                                                >
                                                <button
                                                    class="btn btn-outline-danger"
                                                    onclick="borrarArchivo_inputdocumento('#idinput_fichainscripcionfirmada', '#check_fichainscripcion')"
                                                    id="btneliminar_fichainscripcionfirmada"
                                                        type="button">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documento Vigencia de Poder -->
                                <div class="col-md-6" id="idgrupo_vigenciapoder">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2" id="idlabel_vigenciapoder">
                                                Vigencia de Poder.
                                                <span id="check_vigenciapoder" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input onchange="mostrarCheck_inputdocumento(this, '#check_vigenciapoder')"  type="file" class="form-control" id="idinput_vigenciapoder" accept="application/pdf">
                                                <button onclick="borrarArchivo_inputdocumento('#idinput_vigenciapoder', '#check_vigenciapoder')" class="btn btn-outline-danger" type="button" id="idbotoneliminar_vigenciapoder">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Documento Copia de la partida registral de la empresa. -->
                                <div class="col-md-6" id="idgrupo_partidaregistraoempresa">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                                Copia de la partida registral de la empresa.
                                                <span id="check_partidaempresa" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input onchange="mostrarCheck_inputdocumento(this, '#check_partidaempresa')" type="file" class="form-control" id="idinput_partidaregistraoempresa" accept="application/pdf">
                                                <button onclick="borrarArchivo_inputdocumento('#idinput_partidaregistraoempresa', '#check_partidaempresa')" class="btn btn-outline-danger" type="button" id="idbotoneliminar_partidaregistraoempresa">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documento Reporte de terceros Sunat. -->
                                <div class="col-md-6" id="idgrupo_reportetercerossunat">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                                Reporte de terceros Sunat.
                                                <span id="check_reportetercerosunat" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input onchange="mostrarCheck_inputdocumento(this, '#check_reportetercerosunat')" type="file" class="form-control" id="idinput_reportetercerossunat" accept="application/pdf">
                                                <button onclick="borrarArchivo_inputdocumento('#idinput_reportetercerossunat', '#check_reportetercerosunat')" class="btn btn-outline-danger" type="button" id="idbotoneliminar_reportetercerossunat">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documento Comprobante de pago por derecho de afiliación. -->
                                <div class="col-md-6" id="idgrupo_comprobantederechoafiliacion">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                                Comprobante de pago por derecho de afiliación.
                                                <span id="check_comprobanteafiliacion" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input onchange="mostrarCheck_inputdocumento(this, '#check_comprobanteafiliacion')" type="file" class="form-control" id="idinput_comprobantederechoafiliacion" accept="application/pdf">
                                                <button onclick="borrarArchivo_inputdocumento('#idinput_comprobantederechoafiliacion', '#check_comprobanteafiliacion')" class="btn btn-outline-danger" type="button" id="idbotoneliminar_comprobantederechoafiliacion">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Foto de la Empresa. -->
                                <div class="col-md-6">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold">
                                                Logo de la Empresa.
                                                <span id="check_fotologo" class="text-success" style="display:none;">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <input onchange="mostrarCheck_inputdocumento(this, '#check_fotologo')" type="file" class="form-control" data-tipo="imagen" accept="image/*" name="inputlogoempresa" id="inputlogoempresa">
                                                <button onclick="borrarArchivo_inputdocumento('#inputlogoempresa', '#check_fotologo')" class="btn btn-outline-danger" type="button">
                                                    <i class="bi bi-x-circle"></i> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit">Registrar Socio</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>socios.js"></script>

<script>
    $(document).ready(function () {
        let parametros = <?= json_encode($datos) ?>; // vendrá null o con info
        listarcategoriaselectapi(parametros);
        if (parametros) {
            editar_vista_socio(parametros);
        }

        // $("#id_beneficio").on("change", function(){
        //     let optionSelected = $(this).find(":selected");
        //     $("#idlabelcantbeneficio").text(optionSelected.data("tipocant"));
        //     $("#idinputcuotamensualafiliacion").val("");
        //     $("#idinputcuotaingresoafiliacion").val("");
        //     $("#idinputcantbeneficio").val("0");
        //     listarcategoriaselectapi(parametros);
        // });

        $("#idselect_categoriaafiliado").on("change", function() {
            let optionSelected = $(this).find(":selected");

            let datos = {
                id: optionSelected.val(),
                nombre: optionSelected.text(),
                cuota: optionSelected.data("cuota"),
                cuotaAnual: optionSelected.data("cuota-anual"),
                estado: optionSelected.data("estado"),
                horasAuditorio: optionSelected.data("horas-auditorio"),
                inscripcion: optionSelected.data("inscripcion"),
                usuario: optionSelected.data("usuario")
            };

            // console.log(JSON.stringify(datos));
            $("#idinputcuotamensualafiliacion").val(datos["cuota"]);
            $("#idinputcuotaingresoafiliacion").val(datos["inscripcion"]);
            $("#idinputcantbeneficio").val(optionSelected.data("cant"));
        });

        $("#idformularioafiliado").on("submit", function (e) {
            if (!this.checkValidity()) {
                // Muestra tooltip nativo
                this.reportValidity();
                e.preventDefault(); // Evita envío real
                return;
            }

            e.preventDefault(); // Ahora sí evitamos envío si todo es válido
            let datos = $(this).serializeArray();
            Swal.fire({
                title: `¿Estás seguro con los datos?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    guardarsocio(datos);
                }
            });
        });
    });
</script>