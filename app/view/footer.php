<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 14/10/2020
 * Time: 21:47
 */
?>
<!-- Footer -->


        </div>
    </div>
</div>

<script type="text/javascript">
    document.title = "<?= $_SESSION['controlador'] . '/' . $_SESSION['accion'] . ' - ' . _TITLE_;?>";
</script>

<!--JS para información personal del usuario-->
<script src="<?php echo _SERVER_ . _JS_;?>jquery-3.6.3.min.js"></script>

<script src="<?php echo _SERVER_ . _JS_;?>datos_personales.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>js/sb-admin-2.min.js"></script>
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>js/demo/datatables-demo.js"></script>
<!--SweetAlert-->
<script src="<?=_SERVER_ . _LIBS_;?>sweetalert/sweetalert2.min.js"></script>
<script src="<?=_SERVER_ . _JS_;?>main-sweet.js"></script>
<!-- nuevos script -->
<script src="<?=_SERVER_._STYLES_ASSETS_?>vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?=_SERVER_._STYLES_ASSETS_?>js/bootstrap.bundle.min.js"></script>
<!--<script src="--><?php //=_SERVER_._STYLES_ASSETS_?><!--vendors/apexcharts/apexcharts.js"></script>-->
<!--<script src="--><?php //=_SERVER_._STYLES_ASSETS_?><!--js/pages/dashboard.js"></script>-->
<script src="<?=_SERVER_._STYLES_ASSETS_?>js/main.js"></script>
<script src="<?=_SERVER_._STYLES_ASSETS_?>js/chart.js"></script>
<script src="<?= _SERVER_ . _STYLES_ASSETS_;?>js/select2.full.min.js"></script>



</body>

</html>