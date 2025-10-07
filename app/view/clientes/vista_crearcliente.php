<?php
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?= $_SESSION['controlador'] . '/' . $_SESSION['accion']; ?>
        </h1>
    </div>

    <!-- Formulario Cliente -->
    <div class="row">
        <form id="idformularioclienteadd">
            <div class="row g-3">
                <!-- Tipo Persona -->
                <div class="col-md-4">
                    <label class="form-label">Tipo Persona</label>
                    <select name="cliente_tipopersona" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        <option value="1">Natural</option>
                        <option value="2">Jurídica</option>
                    </select>
                </div>

                <!-- Tipo Documento -->
                <div class="col-md-4">
                    <label class="form-label">Tipo Documento</label>
                    <select name="id_tipodocumento" class="form-select" required>
                        <option value="">Seleccione una opción</option>
<!--                        <option value="">-- Seleccione --</option>-->
<!--                        <option value="1">DNI</option>-->
<!--                        <option value="2">RUC</option>-->
<!--                        <option value="3">Pasaporte</option>-->
                    </select>
                </div>

                <!-- Número -->
                <div class="col-md-4">
                    <label class="form-label">Número Documento</label>
                    <input type="text" name="cliente_numero" class="form-control" maxlength="15" required>
                </div>

                <!-- Razón Social -->
                <div class="col-md-12">
                    <label class="form-label">Razón Social</label>
                    <input type="text" name="cliente_razonsocial" class="form-control" maxlength="300">
                </div>

                <!-- Nombre -->
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="cliente_nombre" class="form-control" maxlength="200">
                </div>

                <!-- Correo -->
                <div class="col-md-6">
                    <label class="form-label">Correo</label>
                    <input type="email" name="cliente_correo" class="form-control" maxlength="200">
                </div>

                <!-- Celulares -->
                <div class="col-md-3">
                    <label class="form-label">Celular 1</label>
                    <input type="text" name="cliente_celular1" class="form-control" maxlength="10">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Celular 2</label>
                    <input type="text" name="cliente_celular2" class="form-control" maxlength="10">
                </div>

                <!-- Teléfonos -->
                <div class="col-md-3">
                    <label class="form-label">Teléfono 1</label>
                    <input type="text" name="cliente_telefono1" class="form-control" maxlength="50">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono 2</label>
                    <input type="text" name="cliente_telefono2" class="form-control" maxlength="10">
                </div>

                <!-- Dirección -->
                <div class="col-md-12">
                    <label class="form-label">Dirección</label>
                    <textarea name="cliente_direccion" class="form-control" rows="2" maxlength="200"></textarea>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>clienteadd.js"></script>
<script>
    $(document).ready(function(){
        cargarselect_tipodocumento();
        $("#idformularioclienteadd").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            guardar_cliente(formData);
        });
    });
</script>