<?php
?>

<!-- Modal Agregar BENIFICOSOCIO -->
<div class="modal fade" id="idmodalagregarbeneficiosocio_vistadetallebeneficio" tabindex="-1" aria-labelledby="idmodalagregarbeneficiosocio_vistadetallebeneficioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Uso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="idmensaje" style="display: none">
                        <div class="alert alert-danger" role="alert">
                            Ya alcanzaste la cantidad máxima permitida este mes.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="idselectbeneficio">Seleccione Beneficio</label>
                        <select class="form-control" id="idselectbeneficio" name="idselectbeneficio" required>
                            <option value="0" selected>Seleccione Beneficio</option>
                            <?php foreach ($beneficios as $tc): ?>
                                <option
                                    data-service='<?= json_encode($tc, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>'
                                    value="<?php echo $tc->id_beneficio ?>"
                                ><?php echo $tc->beneficio_nombre ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="recipient-name" id="idlblcant">Cant de :</label>
                        <input
                                type="number"
                                class="form-control"
                                id="idinputcantidad_vista_sociodetallebeneficio"
                                value="0"
                                min="0"
                                onchange="validarbeneficiosuso()"
                        >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button
                    type="button"
                    class="btn btn-primary"
                    id="idbtnguardar_beneficiousoSocio"
                    onclick="registrar_usobeneficiosSocioBackend()"
                    >Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?>
        </h1>
        <button class="btn btn-primary me-2" data-bs-toggle="modal"
                data-bs-target="#idmodalagregarbeneficiosocio_vistadetallebeneficio"
                onclick="limpiar_inputsmodal_vista_sociodetallebeneficio()">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Uso del Beneficio
        </button>
    </div>

    <!-- Resumen por Beneficio -->
    <?php if (!empty($usoactual) && $usoactual[0]->cantidad_maxima_mes !== null): ?>
        <div class="row mb-4">
            <?php foreach ($usoactual as $uso): ?>
                <div class="col-md-4">
                    <div class="card summary-card mb-3">
                        <div class="card-body text-center">
                            <h6 class="text-muted"><?= ucfirst(strtolower($uso->beneficio_nombre)) ?></h6>
                            <div class="row">
                                <div class="col-4 border-end">
                                    <small>Permitidos</small>
                                    <h5 class="fw-bold"><?= $uso->cantidad_maxima_mes ?></h5>
                                </div>
                                <div class="col-4 border-end">
                                    <small>Usados</small>
                                    <h5 class="fw-bold text-success"><?= $uso->cantidad_usada_mes ?></h5>
                                </div>
                                <div class="col-4">
                                    <small>Disponibles</small>
                                    <h5 class="fw-bold text-primary"><?= $uso->cantidad_restante ?></h5>
                                </div>
                            </div>
                            <small class="text-muted">Última actualización: <?= date("d/m/Y") ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            No tiene Beneficios Registrados del mes actual!
        </div>
    <?php endif; ?>

    <!-- Acordeón Mejorado con PHP -->
    <div class="accordion" id="accordionUsoBeneficios">
        <?php foreach ($resumen as $i => $mes): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= $i ?>">
                    <div class="custom-accordion-header">
                        <!-- Botón principal del acordeón (solo con el contenido) -->
                        <button class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $i ?>"
                                aria-expanded="false"
                                aria-controls="collapse<?= $i ?>">
                            <div class="accordion-info">
                                <span class="accordion-title"><?= htmlspecialchars($mes->periodo) ?></span>
                                <small class="accordion-subtitle">Total usados: <?= (int)$mes->cantidad_usada_mes ?></small>
                            </div>
                        </button>

                        <!-- Controles FUERA del botón principal -->
                        <div class="accordion-controls">
                            <button type="button"
                                    class="btn accordion-delete-btn"
                                    title="Eliminar mes <?= htmlspecialchars($mes->periodo) ?>"
                                    onclick="eliminarMes('<?= htmlspecialchars($mes->periodo) ?>');">
                                <i class="bi bi-trash"></i>
                            </button>
                            <i class="bi bi-chevron-down accordion-toggle-icon"></i>
                        </div>
                    </div>
                </h2>

                <div id="collapse<?= $i ?>" class="accordion-collapse collapse"
                     aria-labelledby="heading<?= $i ?>" data-bs-parent="#accordionUsoBeneficios">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table accordion-table mb-0">
                                <thead>
                                <tr>
                                    <th>Beneficio</th>
                                    <th class="text-center">Cantidad</th>
                                    <th>Fecha</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detalle as $d): ?>
                                        <?php if ($d->periodo == $mes->periodo): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($d->beneficio_nombre) ?></td>
                                                <td class="text-center">
                                                    <span class="quantity-badge"><?= (int)$d->sociobeneficioacumulado_cant ?></span>
                                                    <?= $d->tipobenificios_nombre ?>

                                                </td>
                                                <td><?= htmlspecialchars($d->sociobeneficioacumulado_fecha) ?></td>
                                                <td class="text-center">
                                                    <button class="btn table-delete-btn"
                                                            onclick = "preguntar('¿Seguro que deseas Eliminar el Uso?','eliminarUsoBeneficio','Si','No', <?= (int)$d->id_sociobeneficioacumulado ?>)">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Estilos del acordeón mejorado */
    .accordion {
        --bs-accordion-border-width: 0;
        --bs-accordion-border-radius: 0;
    }

    .accordion-item {
        border: none !important;
        margin-bottom: 12px;
        border-radius: 12px !important;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        background: white;
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        transform: translateY(-1px);
    }

    .accordion-header {
        margin-bottom: 0;
    }

    .accordion-button {
        border: none !important;
        background: transparent !important;
        color: #2c3e50 !important;
        padding: 16px 20px;
        font-weight: 500;
        box-shadow: none !important;
        border-radius: 12px !important;
        flex: 1; /* Ocupa el espacio disponible */
        text-align: left;
        outline: none !important;
        margin: 0;
    }

    .accordion-button:not(.collapsed) {
        background: #f8f9ff !important;
        color: #5a67d8 !important;
    }

    .accordion-button:focus {
        border: none !important;
        box-shadow: 0 2px 8px rgba(90, 103, 216, 0.15) !important;
        outline: none !important;
    }

    .accordion-button:active {
        border: none !important;
        outline: none !important;
    }

    .accordion-button:focus-visible {
        outline: none !important;
        box-shadow: 0 2px 8px rgba(90, 103, 216, 0.15) !important;
    }

    /* Remover el ícono por defecto de Bootstrap */
    .accordion-button::after {
        display: none !important;
    }

    /* ESTRUCTURA CORRECTA: Header personalizado */
    .custom-accordion-header {
        display: flex;
        align-items: center;
        width: 100%;
        position: relative;
        background: white;
        border-radius: 12px;
        overflow: hidden;
    }

    .accordion-button {
        border: none !important;
        background: transparent !important;
        color: #2c3e50 !important;
        padding: 16px 20px;
        font-weight: 500;
        box-shadow: none !important;
        border-radius: 12px !important;
        flex: 1; /* Ocupa el espacio disponible */
        text-align: left;
        outline: none !important;
        margin: 0;
    }

    .accordion-button:not(.collapsed) {
        background: #f8f9ff !important;
        color: #5a67d8 !important;
    }

    .accordion-button:focus {
        border: none !important;
        box-shadow: 0 2px 8px rgba(90, 103, 216, 0.15) !important;
        outline: none !important;
    }

    .accordion-button:active {
        border: none !important;
        outline: none !important;
    }

    .accordion-button:focus-visible {
        outline: none !important;
        box-shadow: 0 2px 8px rgba(90, 103, 216, 0.15) !important;
    }

    /* Información del mes dentro del botón */
    .accordion-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }

    .accordion-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 2px;
        color: inherit;
        line-height: 1.2;
    }

    .accordion-subtitle {
        font-size: 13px;
        color: #64748b;
        font-weight: 400;
        line-height: 1.2;
    }

    /* Controles FUERA del botón principal */
    .accordion-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 20px 16px 0;
        flex-shrink: 0;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
    }

    /* Botón eliminar */
    .accordion-delete-btn {
        padding: 6px 8px;
        font-size: 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        z-index: 10;
    }

    .accordion-delete-btn:hover {
        background: #fee2e2 !important;
        border-color: #fca5a5 !important;
        color: #dc2626 !important;
        transform: scale(1.05);
    }

    /* Ícono dinámico de toggle */
    .accordion-toggle-icon {
        font-size: 16px;
        color: #64748b;
        transition: transform 0.3s ease, color 0.3s ease;
        cursor: pointer;
    }

    /* Estado contraído */
    .custom-accordion-header .accordion-button.collapsed ~ .accordion-controls .accordion-toggle-icon {
        transform: rotate(0deg);
        color: #64748b;
    }

    /* Estado expandido */
    .custom-accordion-header .accordion-button:not(.collapsed) ~ .accordion-controls .accordion-toggle-icon {
        transform: rotate(180deg);
        color: #5a67d8;
    }

    /* Contenido del acordeón */
    .accordion-collapse {
        border-top: 1px solid #e2e8f0;
    }

    .accordion-body {
        padding: 0 !important;
    }

    /* Tabla dentro del acordeón */
    .accordion-table {
        margin: 0;
        border-radius: 0;
    }

    .accordion-table thead th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        padding: 12px 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .accordion-table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }

    .accordion-table tbody tr:hover {
        background: #f8fafc;
    }

    .accordion-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge de cantidad */
    .quantity-badge {
        background: #e0e7ff;
        color: #3730a3;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
    }

    /* Botón de eliminar en tabla */
    .table-delete-btn {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        transition: all 0.2s ease;
    }

    .table-delete-btn:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    /* Card de resumen superior */
    .summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .accordion-header-content {
            gap: 8px;
        }

        .accordion-button {
            padding: 12px 16px;
        }

        .accordion-controls {
            gap: 6px;
        }
    }
</style>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>socio_detallebeneficio.js"></script>
<script>
    $(document).ready(function () {
        let usoactual = <?= json_encode($usoactual) ?>; // vendrá null o con info
        alimentarvaraibleslocales(usoactual);


        // Prevenir que el botón eliminar expanda/contraiga el acordeón
        $(".accordion-delete-btn").on("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Manejar ícono dinámico correctamente al mostrar/ocultar
        $("[data-bs-toggle='collapse']").each(function () {
            const $button = $(this);
            const targetSelector = $button.data("bs-target");
            const $target = $(targetSelector);

            if ($target.length) {
                $target.on("show.bs.collapse", function () {
                    $button.removeClass("collapsed");
                });

                $target.on("hide.bs.collapse", function () {
                    $button.addClass("collapsed");
                });
            }
        });

        // Hacer que el ícono también pueda expandir/contraer
        $(".accordion-toggle-icon").on("click", function () {
            const $header = $(this).closest(".custom-accordion-header");
            const $button = $header.find(".accordion-button");
            $button.trigger("click");
        });

        $("#idselectbeneficio").on("change", function() {
            const dataService = $(this).find(":selected").data("service");
            $("#idlblcant").text(`Cant de ${dataService.tipobenificios_nombre}`);
            validarbeneficiosuso()
        });

    });
</script>
