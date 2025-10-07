<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 14/10/2020
 * Time: 21:44
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?=_SERVER_ ;?>media/logo/logoactual.png">
    <title><?= _TITLE_?></title>
    <link href="<?= _SERVER_ . _STYLES_ASSETS_?>vendors/fontawasone/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<!--    <script src="--><?php //= _SERVER_ . _STYLES_ADMIN_?><!--vendor/jquery/jquery.min.js"></script>-->
    <link rel="stylesheet" href="<?=_SERVER_ . _LIBS_?>sweetalert/sweetalert2.min.css">
    <!-- LINK PARA LA PAGINA NUEVA    -->
    <link rel="stylesheet" href="<?=_SERVER_._STYLES_ASSETS_?>css/bootstrap.css">
    <link rel="stylesheet" href="<?=_SERVER_._STYLES_ASSETS_?>vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?=_SERVER_._STYLES_ASSETS_?>vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=_SERVER_._STYLES_ASSETS_?>css/app.css">
    <link rel="shortcut icon" href="<?=_SERVER_._STYLES_ASSETS_?>images/favicon.svg" type="image/x-icon">
    <script src="<?php echo _SERVER_ . _JS_;?>jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="<?=_SERVER_._STYLES_ASSETS_?>css/select2.min.css">

    <style>
        .readonly_select {
            pointer-events: none;
            background: lightgrey
        }

        .no-show {
            display: none;
        }

        /* Bordes redondeados y sombra */
        .table {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        /* Encabezado más atractivo */
        .table thead th {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: #fff;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        /* Zebra con colores suaves */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9fbfd;
        }

        /* Hover elegante */
        .table-hover tbody tr:hover {
            background-color: #eef5ff;
            transform: scale(1.01);
            transition: all 0.2s ease-in-out;
        }

        /* Celdas */
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }

        /* Estado aceptado / con observaciones */
        .table td.estado {
            font-weight: bold;
            padding: 0.5rem;
        }
        .table td.estado.aceptado {
            color: #28a745;
        }
        .table td.estado.observacion {
            color: #ffc107;
        }

    </style>

</head>