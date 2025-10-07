<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/facturacion/Clientes.php';
require 'app/models/facturacion/Ventas.php';
require 'app/models/facturacion/VentaDetalle.php';
require 'app/models/Servicios.php';
require 'app/models/Serie.php';
require 'app/models/facturacion/GeneradorXML.php';
require 'app/models/facturacion/ApiFacturacion.php';
require 'app/models/facturacion/Nmletras.php';
require 'app/models/facturacion/VentaCuotas.php';
require 'app/models/facturacion/VentaAnulada.php';




class VentasController{
    private $rol;
    private $menu;

    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;

    // variables que se usan de instancias en el controlador
    private $ventas;
    private $clientes;

    private $servicios;

    private $ventadetalle;

    private $serie;

    private $generadorXML;

    private $apiFacturacion;

    private $numLetra;
    private $numeroletras;

    private $ventacuota;
    private $ventaanulada;

    public function __construct() {
        //Instancias especificas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();

        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->ventas = new Ventas();
        $this->clientes = new Clientes();
        $this->servicios = new Servicios();
        $this->ventadetalle = new Ventadetalle();
        $this->serie = new Serie();
        $this->generadorXML = new GeneradorXML();
        $this->apiFacturacion = new ApiFacturacion();
        $this->numLetra = new Nmletras();
        $this->numeroletras = new Numberletras();
        $this->ventacuota = new VentaCuotas();
        $this->ventaanulada = new VentaAnulada();
    }

    public function vista_ver_ventas(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $fecha_inicio = '2025-09-01';
            $fecha_fin = '2025-12-10';

            //$arrayventas = $this->ventas->listar_ventas();
            $arrayventas = $this->ventas->listar_ventas_fechas($fecha_inicio, $fecha_fin);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/vista_ver_venta.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_detalleventa(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }

            $venta = $this->ventas->listar_venta($id);
            $detalle_venta = $this->ventadetalle->listar_detalle_ventas($id);

            //LISTAMOS LOS CLIENTES
//            $clientes = $this->ventas->listar_clientes_porID($venta->id_cliente);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/vista_detalleventa.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_ver_ventas_sunat(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            if(empty($_POST['fecha_fin']) || empty($_POST['fecha_inicio'])){
                $fecha_fin = date('Y-m-d');
                $fecha_inicio = date('Y-m-d', strtotime($fecha_fin . ' - 30 days'));
            } else {
                $fecha_fin = $_POST['fecha_fin'];
                $fecha_inicio = $_POST['fecha_inicio'];
            }
            //$arrayventas = $this->ventas->listar_ventas();
            $arrayventas = $this->ventas->listar_ventas_fechas_sunat($fecha_inicio, $fecha_fin);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/vista_ver_ventas_sunat.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_realizar_venta(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $_SESSION['productos'] = array();

            //LISTAMOS LOS Servicios
            $productos = $this->servicios->listar_servicios();

            //LISTAMOS LOS CLIENTES
            $clientes = $this->ventas->listar_clientes();

            $tiponotacredito = $this->ventas->listAllCredito();
            $tiponotadebito = $this->ventas->listAllDebito();
            $tipo_pago = $this->ventas->listar_tipo_pago();
            $tipos_documento = $this->clientes->listar_documentos();
            $tipo_comprobante = $this->serie->listar_TipoComprobante();

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/vista_realizar_venta.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_ver_ventas_anulados(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $fecha_ini = "";
            $fecha_fin = "";
            if(!empty($_POST) && $_POST['fecha_inicio'] !== "" && $_POST['fecha_fin'] !== ""){
                $bajas = $this->ventas->listar_comunicacion_baja_fecha($_POST['fecha_inicio'], $_POST['fecha_final'], true);
                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
            }else{
                $bajas = $this->ventas->listar_comunicacion_baja_fecha();
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/vista_ver_ventas_anulados.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_realizar_nota(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }
            $venta = $this->ventas->listar_venta($id);
            $detalle_venta = $this->ventadetalle->listar_detalle_ventas($id);
            $tipo_pago = $this->ventas->listar_tipo_pago();
            $productos = $this->servicios->listar_servicios();

            //LISTAMOS LOS CLIENTES
            $clientes = $this->ventas->listar_clientes();
            $tipos_documento = $this->clientes->listar_documentos();

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/vista_realizar_nota.php';
            require _VIEW_PATH_ . 'footer.php';
        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function tabla_productos_html(){
        try{
            require _VIEW_PATH_ . 'ventas/components/tabla_productos_html.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<br><br><div style='text-align: center'><h3>Ocurrió Un Error Al Cargar La Informacion</h3></div>";
        }
    }

    public function consultar_serie(){
        try{
            $concepto = $_POST['concepto'];
            $series = "";
            $correlativo = "";
            if($concepto == "LISTAR_SERIE"){
                $series = $this->serie->listarSerie($_POST['tipo_venta']);
            }else{
                $correlativo_ = $this->serie->listar_correlativos_x_serie($_POST['id_serie']);
                $correlativo = $correlativo_->correlativo + 1;
            }
            //$series = $this->pedido->listarSerie($_POST['tipo_venta']);
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        $respuesta = array("serie" => $series, "correlativo" =>$correlativo);
        echo json_encode($respuesta);
    }

    //Funciones de Guardado de la venata
    public function guardar_venta() {
        $result = 0;
        $message = 'OK';

        try{
            $idcliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : "0";
            $idusuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);


            if($idcliente === "0"){
                //Si el cliente no existe, lo0 registramos y traigo
                if($_POST['venta_tipo'] == "1"){
                    $this->clientes->cliente_tipopersona = 2;
                    $this->clientes->id_tipodocumento = 4;
                    $this->clientes->cliente_razonsocial = isset($_POST['client_name']) ? $_POST['client_name'] : null;
                }else{
                    $this->clientes->cliente_tipopersona = 1;
                    $this->clientes->id_tipodocumento = 2;
                    $this->clientes->cliente_nombre = isset($_POST['client_name']) ? $_POST['client_name'] : null;
                }

                $this->clientes->cliente_numero = isset($_POST['client_number']) ? $_POST['client_number'] : null;
                $this->clientes->cliente_correo =isset($_POST['venta_tipo_moneda']) ? $_POST['venta_tipo_moneda'] : null;
                $this->clientes->cliente_direccion = isset($_POST['client_direccion']) ? $_POST['client_direccion'] : null;
                $this->clientes->cliente_telefono = isset($_POST['venta_tipo_moneda']) ? $_POST['venta_tipo_moneda'] : null;
                $this->clientes->cliente_fecha = date('Y-m-d H:i:s');
                $idcliente = $this->clientes->guardar($this->clientes);
            }

            $this->ventas->id_empresa               = 1;
            $this->ventas->id_usuario               = $idusuario;
            $this->ventas->id_cliente               = $idcliente;
            $this->ventas->id_tipo_pago             = isset($_POST['id_tipo_pago']) ? $_POST['id_tipo_pago'] : null;
            $this->ventas->id_moneda                = isset($_POST['venta_tipo_moneda']) ? $_POST['venta_tipo_moneda'] : null;
            $this->ventas->venta_condicion_resumen  = isset($_POST['venta_condicion_resumen']) ? $_POST['venta_condicion_resumen'] : 0;
            $this->ventas->venta_tipo_envio         = isset($_POST['venta_tipo_envio']) ? $_POST['venta_tipo_envio'] : 0;
            $this->ventas->venta_direccion          = isset($_POST['venta_direccion']) ? $_POST['venta_direccion'] : null;
            $this->ventas->venta_tipo               = isset($_POST['venta_tipo']) ? $_POST['venta_tipo'] : null;
            $this->ventas->venta_serie              = isset($_POST['venta_serie']) ? $_POST['venta_serie'] : null;
            $this->ventas->venta_correlativo        = isset($_POST['venta_correlativo']) ? $_POST['venta_correlativo'] : null;
            $this->ventas->venta_descuento_global   = isset($_POST['venta_descuento_global']) ? $_POST['venta_descuento_global'] : 0.00;
            $this->ventas->venta_totalgratuita      = isset($_POST['venta_totalgratuita']) ? $_POST['venta_totalgratuita'] : 0.00;
            $this->ventas->venta_totalexonerada     = isset($_POST['venta_totalexonerada']) ? $_POST['venta_totalexonerada'] : 0.00;
            $this->ventas->venta_totalinafecta      = isset($_POST['venta_totalinafecta']) ? $_POST['venta_totalinafecta'] : 0.00;
            $this->ventas->venta_totalgravada       = isset($_POST['venta_totalgravada']) ? $_POST['venta_totalgravada'] : 0.00;
            $this->ventas->venta_totaligv           = isset($_POST['venta_totaligv']) ? $_POST['venta_totaligv'] : 0.00;
            $this->ventas->venta_incluye_igv        = isset($_POST['venta_incluye_igv']) ? $_POST['venta_incluye_igv'] : 1;
            $this->ventas->venta_totaldescuento     = isset($_POST['venta_totaldescuento']) ? $_POST['venta_totaldescuento'] : 0.00;
            $this->ventas->venta_icbper             = isset($_POST['venta_icbper']) ? $_POST['venta_icbper'] : 0.00;
            $this->ventas->venta_total              = isset($_POST['venta_total']) ? $_POST['venta_total'] : 0.00;
            $this->ventas->venta_pago_cliente       = isset($_POST['venta_pago_cliente']) ? $_POST['venta_pago_cliente'] : 0.00;
            $this->ventas->venta_vuelto             = isset($_POST['venta_vuelto']) ? $_POST['venta_vuelto'] : 0.00;
            $this->ventas->venta_fecha              = isset($_POST['venta_fecha']) ? $_POST['venta_fecha'] : null;
            $this->ventas->venta_observacion        = isset($_POST['venta_observacion']) ? $_POST['venta_observacion'] : null;            ;
            $this->ventas->venta_estado_sunat       = isset($_POST['venta_estado_sunat']) ? $_POST['venta_estado_sunat'] : 0;
            $this->ventas->venta_fecha_envio        = isset($_POST['venta_fecha_envio']) ? $_POST['venta_fecha_envio'] : null;
            $this->ventas->venta_rutaXML            = isset($_POST['venta_rutaXML']) ? $_POST['venta_rutaXML'] : null;
            $this->ventas->venta_rutaCDR            = isset($_POST['venta_rutaCDR']) ? $_POST['venta_rutaCDR'] : null;
            $this->ventas->venta_respuesta_sunat    = isset($_POST['venta_respuesta_sunat']) ? $_POST['venta_respuesta_sunat'] : null;
            $this->ventas->venta_fecha_de_baja      = isset($_POST['venta_fecha_de_baja']) ? $_POST['venta_fecha_de_baja'] : null;
            $this->ventas->anulado_sunat            = isset($_POST['anulado_sunat']) ? $_POST['anulado_sunat'] : 0;
            $this->ventas->venta_cancelar           = isset($_POST['venta_cancelar']) ? $_POST['venta_cancelar'] : 1;


            //Parametro de Nota de Débito y credito
            if($this->ventas->venta_tipo === "07" || $this->ventas->venta_tipo === "08"){
                $this->ventas->tipo_documento_modificar = isset($_POST['tipo_documento_modificar']) ? $_POST['tipo_documento_modificar'] : null;
                $this->ventas->serie_modificar          = isset($_POST['serie_modificar']) ? $_POST['serie_modificar'] : null;
                $this->ventas->correlativo_modificar    = isset($_POST['correlativo_modificar']) ? $_POST['correlativo_modificar'] : null;
                $this->ventas->venta_codigo_motivo_nota = isset($_POST['venta_codigo_motivo_nota']) ? $_POST['venta_codigo_motivo_nota'] : null;
            }

            $formapago = isset($_POST['venta_forma_pago']) ? $_POST['venta_forma_pago'] : "CONTADO";
            $this->ventas->venta_forma_pago = $formapago == "1" ? "CONTADO" : "CREDITO";
            $idventa = $this->ventas->guardar_venta($this->ventas);
            if($idventa == 0){
                throw new Exception('No se pudo guardar la venta');
            }

            if ($idventa !== 0 && !empty($_POST['detalle_venta'])) {
                $detalle_venta = $_POST['detalle_venta'];
                for ($i = 0; $i < count($detalle_venta); $i++) {
                    $this->ventadetalle->id_venta = $idventa;
                    $this->ventadetalle->id_servicio  = $detalle_venta[$i]['id_servicio'];
                    $this->ventadetalle->venta_detalle_descripcion  = $detalle_venta[$i]['venta_detalle_nombre_servicio'];
                    $this->ventadetalle->venta_detalle_cantidad = $detalle_venta[$i]['venta_detalle_cantidad_servicio'];
                    $this->ventadetalle->venta_detalle_total_igv = 0;
                    $this->ventadetalle->venta_detalle_precio_unitario = $detalle_venta[$i]['venta_detalle_precio_unitario'];
                    $this->ventadetalle->venta_detalle_valor_total = $detalle_venta[$i]['venta_detalle_valor_total'];
                    $this->ventadetalle->venta_detalle_porcentaje_igv = 0;
                    $result = $this->ventadetalle->guardar_detalle_venta($this->ventadetalle);
                    if($result == 0){
                        throw new Exception('No se pudo guardar el DetalleVenta');
                    }
                }
            }

            if($formapago == "2" && !empty($_POST['detalle_cuota'])){
                $detalle_cuota = isset($_POST['detalle_cuota']) ? $_POST['detalle_cuota'] : [];
                $cuotas = $detalle_cuota["cuotas"];
                for ($i = 0; $i < count($cuotas); $i++) {
                    $this->ventacuota->id_ventas = $idventa;
                    $this->ventacuota->id_tipo_pago  = $detalle_cuota['id_tipo_pago'];
                    $this->ventacuota->venta_cuota_numero = $cuotas[$i]['venta_cuota_numero'];
                    $this->ventacuota->venta_cuota_importe = $cuotas[$i]['venta_cuota_importe'];
                    $this->ventacuota->venta_cuota_fecha = $cuotas[$i]['venta_cuota_fecha'];
                    $this->ventacuota->venta_cuota_datetime = $this->ventas->venta_fecha;
                    $result = $this->ventacuota->guardar_detalle_cuota($this->ventacuota);
                    if($result == 0){
                        throw new Exception('No se pudo guardar el detalle_cuota');
                    }
                }
            }

            //actualizo el correlativo
            $modeloserie = new Serie();
            $respuesta = $modeloserie->actualizarcorrelativo($this->ventas->venta_serie);

            if(!$respuesta){
                throw new Exception('No se pudo actualizar la serie');
            }

            $exito = $this->crear_tiket($idventa);
            $result = 1;
        }
        catch (Exception $e){
            $message = $e->getMessage();
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        finally{
            //Retornamos el json
            echo json_encode(
                array(
                    "result" => array(
                        "code" => $result,
                        "message" => $message
                    )
                )
            );
        }
    }

    public function crear_xml_enviar_sunat(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_venta = $_POST['id_venta'];
                $venta = $this->ventas->listar_soloventa_x_id($id_venta);
                $detalle_venta = $this->ventadetalle->listar_detalle_ventas($id_venta);
                $empresa = $this->ventas->listar_empresa_x_id_empresa($venta->id_empresa);
                $cliente = $this->ventas->listar_clienteventa_x_id($venta->id_cliente);

                $detalle_cuotas = [];
                if($venta->venta_forma_pago === "CREDITO"){
                    $detalle_cuotas = $this->ventacuota->listar_detalle_cuotas($id_venta);
                }
                //$producto = $this->ventas->listar_producto_x_id($detalle_venta->id_producto);

                //ASIGAMOS NOMBRE AL ARCHIVO XML
                $nombre = $empresa->empresa_ruc.'-'.$venta->venta_tipo.'-'.$venta->venta_serie.'-'.$venta->venta_correlativo;

                $ruta = "libs/ApiFacturacion/xml/";
                //validamos el tipo de comprobante para crear su archivo XML
                if($venta->venta_tipo == '01' || $venta->venta_tipo == '03'){
                    $this->generadorXML->CrearXMLFactura($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta, $detalle_cuotas);
                }else{
                    $detalle_venta = $this->ventadetalle->listar_detalle_ventas($id_venta);
                    if ($venta->venta_tipo == '07'){

                        $descripcion_nota = $this->ventas->listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
                        $this->generadorXML->CrearXMLNotaCredito($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                    }else{
                        $descripcion_nota = $this->ventas->listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                        $this->generadorXML->CrearXMLNotaDebito($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                    }
                }
                //SE PROCEDE A FIRMAR EL XML CREADO
                $result = $this->apiFacturacion->EnviarComprobanteElectronico($empresa,$nombre,"libs/ApiFacturacion/","libs/ApiFacturacion/xml/","libs/ApiFacturacion/cdr/", $id_venta);
                //FIN FACTURACION ELECTRONICA
                if($result == 1){
                    $result = $this->ventas->guardar_estado_de_envio_venta($id_venta, '1', '1');
                }

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function vistaprevia_pdf_a4() {
        try {
            $tipopago = isset($_POST['venta_forma_pago']) ? $_POST['venta_forma_pago'] : "CONTADO";
            $formapago = $tipopago == "1" ? "CONTADO" : "CREDITO";

            $dato_venta = (object)[
                "empresa_ruc" => "20162270134",
                "empresa_razon_social" => "CAMARA DE COMERCIO IND Y TURIS DE LORETO",
                "empresa_domiciliofiscal" => "CAL.HUALLAGA NRO. 311 (TERCER PISO) LORETO - MAYNAS - IQUITOS",
                "cliente_numero" => $_POST['client_number'],
                "cliente_nombre" => $_POST['client_name'],
                "cliente_razonsocial" => $_POST['client_name'],
                "cliente_direccion" => $_POST['client_direccion'],
                "venta_tipo" => $_POST['venta_tipo'],
                "venta_forma_pago" => $formapago,
                "venta_serie" => $_POST['venta_serie'],
                "venta_correlativo" => $_POST['venta_correlativo'],
                "venta_total" => $_POST['venta_total'],
                "venta_totalexonerada" => $_POST['venta_totalexonerada'],
                "venta_observaciones" => "Vista previa de venta",
                "tipo_pago_nombre" => "Pendiente",
                "simbolo" => "S/",
            ];


            $detalle_cuotas = "";
            if (isset($_POST['detalle_cuota']) && $_POST['detalle_cuota']["totalCuotas"] != 0 && $tipopago != 1) {
                foreach ($_POST['detalle_cuota']['cuotas'] as $item) {
                    $fecha_cuota = date('d-m-Y', strtotime($item["venta_cuota_fecha"]));
                    $detalle_cuotas .= " [Cuota {$item["venta_cuota_numero"]} | {$fecha_cuota} | {$item["venta_cuota_importe"]}]";
                }
            }

            $detalle_venta = [];
            if (isset($_POST['detalle_venta'])) {
                foreach ($_POST['detalle_venta'] as $item) {
                    $detalle_venta[] = (object)[
                        "venta_detalle_cantidad" => $item['venta_detalle_cantidad_servicio'],
                        "venta_detalle_descripcion" => $item['venta_detalle_nombre_servicio'],
                        "venta_detalle_precio_unitario" => $item['venta_detalle_precio_unitario'],
                        "venta_detalle_valor_total" => $item['venta_detalle_valor_total'],
                        "venta_detalle_total_igv" => "0.00",
                    ];
                }
            }

            $fecha_hoy = date("Y-m-d");
            $tipo_comprobante = ($_POST['venta_tipo'] === "01") ? "FACTURA DE VENTA ELECTRÓNICA"  : "BOLETA DE VENTA ELECTRÓNICA";

            $serie_correlativo = $dato_venta->venta_serie . "-" . $dato_venta->venta_correlativo;
            $documento = $dato_venta->cliente_numero;
            $dnni = "DNI";

            $montoLetras = "SOLES " . $dato_venta->venta_total;
            $ruta_qr = "media/logo/logoactual.png";
            $dato_impresion = "Vista previa de venta";

            // Renderiza la vista directamente
            require _VIEW_PATH_ . 'ventas/imprimir_ticket_pdf_A4.php';

        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "Error en vista previa de venta";
        }
    }


    public function crear_tiket($idventa): bool {
        //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
        include('libs/ApiFacturacion/phpqrcode/qrlib.php');
        $venta = $this->ventas->listar_venta($idventa);
        $detalle_venta = $this->ventadetalle->listar_detalle_ventas($idventa);
        $empresa = $this->ventas->listar_empresa_x_id_empresa($venta->id_empresa);
        $cliente = $this->ventas->listar_clienteventa_x_id($venta->id_cliente);
        //INICIO - CREACION QR
        $nombre_qr = $empresa->empresa_ruc. '-' .$venta->venta_tipo. '-' .$venta->venta_serie. '-' .$venta->venta_correlativo;
        $contenido_qr = $empresa->empresa_ruc.'|'.$venta->venta_tipo.'|'.$venta->venta_serie.'|'.$venta->venta_correlativo. '|'.
            $venta->venta_totaligv.'|'.$venta->venta_total.'|'.date('Y-m-d', strtotime($venta->venta_fecha)).'|'.
            $cliente->tipodocumento_codigo.'|'.$cliente->cliente_numero;
        $ruta = 'libs/ApiFacturacion/imagenqr/';
        $ruta_qr = $ruta.$nombre_qr.'.png';
        QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
        //FIN - CREACION QR
        if($venta->venta_tipo == "03"){
            $venta_tipo = "BOLETA DE VENTA ELECTRÓNICA";
        }elseif($venta->venta_tipo == "01"){
            $venta_tipo = "FACTURA DE VENTA ELECTRÓNICA";
        }elseif($venta->venta_tipo == "07"){
            $venta_tipo = "NOTA DE CRÉDITO ELECTRÓNICA";
            $motivo = $this->ventas->listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
        }else{
            $venta_tipo = "NOTA DE DÉBITO ELECTRÓNICA";
            $motivo = $this->ventas->listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);

        }
        if($cliente->id_tipodocumento == "4"){
            $cliente_nombre = $cliente->cliente_razonsocial;
        }else{
            $cliente_nombre = $cliente->cliente_nombre;
        }

        return true;
    }

    public function imprimir_ticket_pdf(){
        try{
            $id = $_GET['id'] ?? 0;
            if ($id == 0) {
                throw new Exception('ID Sin Declarar');
            }

            $dato_venta = $this->ventas->listar_venta_x_id_pdf($id);
            $detalle_venta = $this->ventadetalle->listar_detalle_ventas($id);
            $fecha_hoy = date('d-m-Y H:i:s');

            $detalle_cuotas = 'CONTADO';
            if($dato_venta->venta_forma_pago == 'CREDITO'){
                $cuotas = $this->ventacuota->listar_detalle_cuotas($id);
                if(!empty($cuotas)){
                    $detalle_cuotas = 'CRÉDITO';
                    foreach ($cuotas as $cu){
                        $fecha_cuota = date('d-m-Y', strtotime($cu->venta_cuota_fecha));
                        $detalle_cuotas .= " [Cuota {$cu->venta_cuota_numero} | {$fecha_cuota} | {$cu->venta_cuota_importe}]";
                    }
                }
            }

            $ruta_qr = "libs/ApiFacturacion/imagenqr/$dato_venta->empresa_ruc-$dato_venta->venta_tipo-$dato_venta->venta_serie-$dato_venta->venta_correlativo.png";

            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                if($dato_venta->cliente_numero == "11111111"){
                    $documento = "DNI:                        SIN DOCUMENTO";
                }else{
                    $documento = "DNI:                        $dato_venta->cliente_numero";
                }
            } else if ($dato_venta->venta_tipo == "01") {
                $tipo_comprobante = "FACTURA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "RUC:                      $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            } else {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }
            $importe_letra = $this->numLetra->num2letras(intval($dato_venta->venta_total));
            $arrayImporte = explode(".", $dato_venta->venta_total);
            $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;
            //$qrcode = $dato_venta->pago_seriecorrelativo . '-' . $tiempo_fecha[0] . '.png';
            $dato_impresion = 'DATOS DE IMPRESIÓN:';
            require _VIEW_PATH_ . 'ventas/imprimir_ticket_pdf.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function imprimir_ticket_pdf_A4(){
        try {
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $idventa = $_GET["id"];
            $ruta_guardado="";
            $dato_venta = $this->ventas->listar_venta_x_id_pdf($idventa);
            $detalle_venta = $this->ventadetalle->listar_detalle_ventas($idventa);
            $fecha_hoy = $dato_venta->venta_fecha;

            $detalle_cuotas = 'CONTADO';
            if($dato_venta->venta_forma_pago == 'CREDITO'){
                $cuotas = $this->ventacuota->listar_detalle_cuotas($idventa);
                if(!empty($cuotas)){
                    $detalle_cuotas = 'CRÉDITO';
                    foreach ($cuotas as $cu){
                        $fecha_cuota = date('d-m-Y', strtotime($cu->venta_cuota_fecha));
                        $detalle_cuotas .= " [Cuota {$cu->venta_cuota_numero} | {$fecha_cuota} | {$cu->venta_cuota_importe}]";
                    }
                }
            }

            $ruta_qr = "libs/ApiFacturacion/imagenqr/$dato_venta->empresa_ruc-$dato_venta->venta_tipo-$dato_venta->venta_serie-$dato_venta->venta_correlativo.png";
            $dnni="DNI";

            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                if($dato_venta->cliente_numero == "11111111"){
                    $documento = "SIN DOCUMENTO";
                }else{
                    $documento = "$dato_venta->cliente_numero";
                }
            }else if ($dato_venta->venta_tipo == "01") {
                $dnni="RUC";
                $tipo_comprobante = "FACTURA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "$dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "$dato_venta->cliente_numero";
            } else {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "$dato_venta->cliente_numero";
            }
            /*$importe_letra = $this->numLetra->num2letras(intval($dato_venta->venta_total));
            $arrayImporte = explode(".", $dato_venta->venta_total);
            $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;*/
            $montoLetras = $this->numeroletras->toInvoice($dato_venta->venta_total, 2, $dato_venta->moneda);
            //$qrcode = $dato_venta->pago_seriecorrelativo . '-' . $tiempo_fecha[0] . '.png';
            $dato_impresion = 'DATOS DE IMPRESIÓN:';
            require _VIEW_PATH_ . 'ventas/imprimir_ticket_pdf_A4.php';
        }catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    public function excel_ventas_sunat(){
        try {
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            /*$fecha_final = date('Y-m-d');
            $fecha_inicio = date('Y-m-d', strtotime($fecha_final . ' - 30 days'));*/

            if(empty($_GET['fecha_fin']) || empty($_GET['fecha_inicio'])){
                $fecha_final = date('Y-m-d');
                $fecha_inicio = date('Y-m-d', strtotime($fecha_final . ' - 30 days'));
            } else {
                $fecha_final = $_GET['fecha_fin'];
                $fecha_inicio = $_GET['fecha_inicio'];
            }

            $arrayventas = $this->ventas->listar_ventas_fechas_sunat_todos($fecha_inicio, $fecha_final);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $mensaje = "RESULTADO DE LA BUSQUEDA : ";
            $mensaje_="";
            if($arrayventas->venta_tipo == 0){
                $mensaje_ .= ' TODOS ';
            }elseif ($arrayventas->venta_tipo == '03'){
                $mensaje_ .= ' BOLETAS ';
            }elseif ($arrayventas->venta_tipo == '01'){
                $mensaje_ .= ' FACTURAS ';
            }elseif ($arrayventas->venta_tipo == '07'){
                $mensaje_ .= ' NOTAS DE CREDITO ';
            }elseif ($arrayventas->venta_tipo == '08'){
                $mensaje_ .= ' NOTAS DE DEBITO ';
            }
            if(isset($fecha_inicio,$fecha_final)){
                $mensaje.= " TIPO COMPROBANTE ".$mensaje_." DEL ".date("d-m-Y",strtotime($fecha_inicio))." HASTA : ".date("d-m-Y",strtotime($fecha_final));
            }
            // Agregar título en negritas
            $sheet->setCellValue('A1', $mensaje);
            $titleStyle = $sheet->getStyle('A1');
            $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
            $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
            // Combinar celdas para el título
            $sheet->mergeCells('A1:S1');
            // Agregar datos a las celdas para la cabecera
            $sheet->setCellValue('A2', '#');
            $sheet->setCellValue('B2', 'EMPRESA');
            $sheet->setCellValue('C2', 'FECHA DE EMISIÓN');
            $sheet->setCellValue('D2', 'TIPO DE ENVIO');
            $sheet->setCellValue('E2', 'COMPROBANTE');
            $sheet->setCellValue('F2', 'SERIE Y CORRELATIVO');

            $sheet->setCellValue('G2', 'CLIENTE');
            $sheet->setCellValue('H2', 'TIPO DE PAGO');
            $sheet->setCellValue('I2', 'FORMA DE PAGO');
            $sheet->setCellValue('J2', 'MONEDA');

            $sheet->setCellValue('K2', 'DESCUENTO');
            $sheet->setCellValue('L2', 'GRAVADO');
            $sheet->setCellValue('M2', 'EXONERADO');
            $sheet->setCellValue('N2', 'INAFECTO');
            $sheet->setCellValue('O2', 'GRATUITO');
            $sheet->setCellValue('P2', 'IGV');
            $sheet->setCellValue('Q2', 'ICBPER');
            $sheet->setCellValue('R2', 'TOTAL');
//            $sheet->setCellValue('S2', 'ESTADO SUNAT');
            $sheet->setCellValue('S2', 'ESTADO COMPROBANTE');
            // Establecer el ancho de las columnas A a G
            $sheet->getColumnDimension('A')->setWidth(7); // Ancho de la columna A
            $sheet->getColumnDimension('B')->setWidth(30); // Ancho de la columna B
            $sheet->getColumnDimension('C')->setWidth(30); // Ancho de la columna C
            $sheet->getColumnDimension('D')->setWidth(22); // Ancho de la columna D
            $sheet->getColumnDimension('E')->setWidth(22); // Ancho de la columna E
            $sheet->getColumnDimension('F')->setWidth(25); // Ancho de la columna F
            $sheet->getColumnDimension('G')->setWidth(80); // Ancho de la columna G
            $sheet->getColumnDimension('H')->setWidth(25); // Ancho de la columna H
            $sheet->getColumnDimension('I')->setWidth(25); // Ancho de la columna I
            $sheet->getColumnDimension('J')->setWidth(18); // Ancho de la columna J

            $sheet->getColumnDimension('K')->setWidth(22); // Ancho de la columna K
            $sheet->getColumnDimension('L')->setWidth(22); // Ancho de la columna L
            $sheet->getColumnDimension('M')->setWidth(22); // Ancho de la columna M
            $sheet->getColumnDimension('N')->setWidth(22); // Ancho de la columna N
            $sheet->getColumnDimension('O')->setWidth(22); // Ancho de la columna O
            $sheet->getColumnDimension('P')->setWidth(22); // Ancho de la columna P
            $sheet->getColumnDimension('Q')->setWidth(22); // Ancho de la columna Q

            $sheet->getColumnDimension('R')->setWidth(20); // Ancho de la columna R
//            $sheet->getColumnDimension('S')->setWidth(60); // Ancho de la columna S
            $sheet->getColumnDimension('S')->setWidth(60); // Ancho de la columna T

            // Obtener la fila 1 completa (desde A hasta T) como un rango
            $cellRange = 'A2:S2';
            $rowStyle = $sheet->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0b1892'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas

            // contenido de la table
            $row = 3; // Empieza a partir de la terce fila (fila 2 es para encabezados)
            $conteo = 1;
            //$total = 0;
            $total_soles = 0;
            $total_dolares = 0;
            $estado_comprobante='';
            $stylee='';

            foreach ($arrayventas as $item) {
                if($item->venta_tipo == "03"){
                    $tipo_comprobante = "BOLETA";
                    if($item->anulado_sunat == 0){
                        $estado_comprobante = 'REGISTRADO';
                        if($item->id_moneda == 1) {
                            $total_soles = round($total_soles + $item->venta_total, 2);
                        }else{
                            $total_dolares = round($total_dolares + $item->venta_total, 2);
                        }
                    }else{
                        $stylee="style= 'text-align: center; background-color: #FF6B70'";
                        $estado_comprobante = 'ANULADO';
                    }
                }elseif ($item->venta_tipo == "01"){
                    $tipo_comprobante = "FACTURA";
                    if($item->anulado_sunat == 0){
                        $estado_comprobante = 'REGISTRADO';
                        if($item->id_moneda == 1) {
                            $total_soles = round($total_soles + $item->venta_total, 2);
                        }else{
                            $total_dolares = round($total_dolares + $item->venta_total, 2);
                        }
                    }else{
                        $estado_comprobante = 'ANULADO';
                        $stylee="style= 'text-align: center; background-color: #FF6B70'";
                    }

                }elseif($item->venta_tipo == "07"){
                    $estado_comprobante = 'REGISTRADO';
                    $tipo_comprobante = "NOTA DE CRÉDITO";
                }elseif($item->venta_tipo == "08"){
                    $tipo_comprobante = "NOTA DE DÉBITO";
                    if($item->anulado_sunat == 0){
                        $estado_comprobante = 'REGISTRADO';
                        if($item->id_moneda == 1) {
                            $total_soles = round($total_soles + $item->venta_total, 2);
                        }else{
                            $total_dolares = round($total_dolares + $item->venta_total, 2);
                        }
                    }else{
                        $estado_comprobante = 'ANULADO';
                        $stylee="style= 'text-align: center; background-color: #FF6B70'";
                    }
                }else{
                    $tipo_comprobante = "--";
                }

                if($item->venta_tipo_envio == 1){
                    $tipo_venta = 'DIRECTO';
                }elseif($item->venta_tipo_envio == 2){
                    $tipo_venta = 'ENVIADO RESUMEN DIARIO';
                }else{
                    $tipo_venta = 'PENDIENTE DE ENVIO';
                }

                if($item->id_tipodocumento == 4){
                    $cliente = $item->cliente_razonsocial;
                }else{
                    $cliente = $item->cliente_nombre;
                }
                $forma_pago="";

                if($item->id_formas_pago==1){
                    $forma_pago = 'PAGADO';
                }else{
                    if($item->venta_estado_pago==0){
                        $forma_pago = 'PENDIENTE DE PAGO';
                    }elseif ($item->venta_estado_pago==1){
                        $forma_pago = 'PAGADO PARCIALMENTE';
                    }elseif ($item->venta_estado_pago==2){
                        $forma_pago = 'PAGADO';
                    }
                }
                $estilo_mensaje = "";
                if($item->venta_estado_sunat == 1){
                    if($item->venta_respuesta_sunat != ""){
                        $mensaje = $item->venta_respuesta_sunat;
                    }else{
                        $mensaje = 'Aceptado por Resumen Diario';
                    }
                    $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
                }

                if($estado_comprobante == "ANULADO"){
                    $ventaanulada = $this->ventaanulada->listar_detalle_anulados($item->id_venta);
                    $mensaje = $ventaanulada->venta_anulado_estado_sunat;
                }


                $sheet->setCellValue('A' . $row, $conteo);
                $sheet->setCellValue('B' . $row, $item->empresa_nombrecomercial);
                $sheet->setCellValue('C' . $row, date('d-m-Y H:i:s', strtotime($item->venta_fecha)));
                $sheet->setCellValue('D' . $row, $tipo_venta);
                $sheet->setCellValue('E' . $row, $tipo_comprobante);
                $sheet->setCellValue('F' . $row, $item->venta_serie. '-' .$item->venta_correlativo);

                $sheet->setCellValue('G' . $row, $item->cliente_numero. '||' .$cliente);
                $sheet->setCellValue('H' . $row, $item->tipo_pago_nombre);
//                $sheet->setCellValue('I' . $row, $item->id_formas_pago == 1 ? 'CONTADO':'CREDITO' );
                $sheet->setCellValue('I' . $row, $item->venta_forma_pago );

                $sheet->setCellValue('J' . $row, $item->moneda);
                $sheet->setCellValue('K' . $row, $item->venta_totaldescuento);
                $sheet->setCellValue('L' . $row, $item->venta_totalgravada);
                $sheet->setCellValue('M' . $row, $item->venta_totalexonerada);
                $sheet->setCellValue('N' . $row, $item->venta_totalinafecta);
                $sheet->setCellValue('O' . $row, $item->venta_totalgratuita);
                $sheet->setCellValue('P' . $row, $item->venta_totaligv);
                $sheet->setCellValue('Q' . $row, $item->venta_icbper);
                $sheet->setCellValue('R' . $row, number_format($item->venta_total,2));
//                $sheet->setCellValue('S' . $row, $mensaje);
                $sheet->setCellValue('S' . $row, $estado_comprobante);
                if ($estado_comprobante == "ANULADO"){
                    $cellRange = 'A'.$row.':S'.$row;
                    $rowStyle = $sheet->getStyle($cellRange);
                    // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
                    $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ff0000'); // Fondo
                    $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
                    $rowStyle->getFont()->setSize(12); // Tamaño de letra 14
                    $rowStyle->getFont()->setBold(true); // Hacer negritas

                }
                $row++; // Moverse a la siguiente fila
                $conteo++;
            }
            $row = $row+1;
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, '');
            $sheet->setCellValue('C' . $row, '');
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $sheet->setCellValue('F' . $row, '');
            $sheet->setCellValue('G' . $row, '');
            $sheet->setCellValue('H' . $row, '');
            $sheet->setCellValue('I' . $row, '');
            $sheet->setCellValue('J' . $row, '');
            $sheet->setCellValue('k' . $row, '');
            $sheet->setCellValue('L' . $row, '');
            $sheet->setCellValue('M' . $row, '');
            $sheet->setCellValue('N' . $row, '');
            $sheet->setCellValue('O' . $row, '');
            $sheet->setCellValue('P' . $row, '');
            $sheet->setCellValue('Q' . $row, 'TOTAL S/. ');
            $sheet->setCellValue('R' . $row, $total_soles);
//            $sheet->setCellValue('S' . $row, '');
            $sheet->setCellValue('S' . $row, '');
            $row = $row+1;
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, '');
            $sheet->setCellValue('C' . $row, '');
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $sheet->setCellValue('F' . $row, '');
            $sheet->setCellValue('G' . $row, '');
            $sheet->setCellValue('H' . $row, '');
            $sheet->setCellValue('I' . $row, '');
            $sheet->setCellValue('J' . $row, '');
            $sheet->setCellValue('k' . $row, '');
            $sheet->setCellValue('L' . $row, '');
            $sheet->setCellValue('M' . $row, '');
            $sheet->setCellValue('N' . $row, '');
            $sheet->setCellValue('O' . $row, '');
            $sheet->setCellValue('P' . $row, '');
            $sheet->setCellValue('Q' . $row, 'TOTAL $.');
            $sheet->setCellValue('R' . $row, $total_dolares);
//            $sheet->setCellValue('S' . $row, '');
            $sheet->setCellValue('S' . $row, '');


            // Crear una respuesta (response) para el archivo Excel
            $filename = "excel_ventas_enviadas_" . $fecha_final . ".xlsx";

            // Enviar cabeceras para forzar la descarga
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            // Crear y enviar el archivo
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;

        }
        catch  (\Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
    }

    public function comunicacion_baja(){
        //Código de error general
        $result = 1;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_venta = $_POST['id_venta'];

                //$fecha = $_POST['fecha'];
                //$ventas = $this->ventas->listar_venta_x_fecha($fecha, '03');
                //CONTROLAMOS VARIOS ENVIOS EL MISMO DIAS
                $serie = date('Ymd');
                $fila_serie = $this->ventas->listar_serie_resumen('RA');
                $venta = $this->ventas->listar_venta_x_id($id_venta);

                //$correlativo = 1;
                if($fila_serie->serie != $serie){
                    //$result = $this->ventas->actualizar_serie_resumen('RA', $serie);
                    $correlativo = 1;
                }else{
                    $correlativo = $fila_serie->correlativo + 1;
                }

                if($result == 1){
                    //$result = $this->ventas->actualizar_correlativo_resumen('RA', $correlativo);
                    if($result == 1){
                        $cabecera = array(
                            "tipocomp"		=>"RA",
                            "serie"			=>$serie,
                            "correlativo"	=>$correlativo,
                            "fecha_emision" =>date('Y-m-d'),
                            "fecha_envio"	=>date('Y-m-d')
                        );
                        //$cabecera = $this->ventas->listar_serie_resumen('RA');
                        $items = $venta;
                        $ruta = "libs/ApiFacturacion/xml/";
                        $emisor = $this->ventas->listar_empresa_x_id_empresa('1');
                        $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];

                        //CREAMOS EL XML DEL RESUMEN
                        $this->generadorXML->CrearXmlBajaDocumentos($emisor, $cabecera, $items, $ruta.$nombrexml);

                        $result = $this->apiFacturacion->EnviarResumenComprobantes($emisor,$nombrexml,"libs/ApiFacturacion/","libs/ApiFacturacion/xml/");
                        $ticket = $result['ticket'];
                        if($result['result'] == 1){
                            $id_user = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                            $ruta_xml = $ruta.$nombrexml.'.XML';
                            $guardar_anulacion =$this->ventas->guardar_venta_anulacion(date('Y-m-d', strtotime($venta->venta_fecha)),$cabecera['serie'],$cabecera['correlativo'],$ruta_xml,$result['mensaje'],$id_venta,$id_user,$result['ticket']);
                            if($guardar_anulacion == 1){
                                if($fila_serie->serie != $serie){
                                    $result = $this->ventas->actualizar_serie_resumen('RA', $serie);
                                }
                                $this->ventas->actualizar_correlativo_resumen('RA', $correlativo);
                                $result = $this->ventas->editar_estado_venta_anulado($id_venta);
                                if($result == 1){
                                    $result = $this->apiFacturacion->ConsultarTicket($emisor, $cabecera, $ticket,"libs/ApiFacturacion/cdr/",2);
                                }

                            }
                        }elseif($result['result'] == 4){
                            $result = 4;
                            $message = $result['mensaje'];
                        }elseif($result['result'] == 3){
                            $result = 3;
                        }
                    }
                }


            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }


    //* ----------------------------------- *//
    //Logica de la Nota de Credito y Débito

    public function consultar_serie_nota(){
        try{
            $concepto = $_POST['concepto'];
            $series = "";
            $correlativo = "";
            if($concepto == "LISTAR_SERIE"){
                $tipo_documento_modificar = $_POST['tipo_documento_modificar'];
                if($tipo_documento_modificar == "01" && $_POST['tipo_venta'] == "07"){
                    $id_serie = 5;
                }elseif($tipo_documento_modificar == "03" && $_POST['tipo_venta'] == "07"){
                    $id_serie = 6;
                }elseif($tipo_documento_modificar == "01" && $_POST['tipo_venta'] == "08"){
                    $id_serie = 7;
                }elseif($tipo_documento_modificar == "03" && $_POST['tipo_venta'] == "08"){
                    $id_serie = 8;
                }
                $series = $this->serie->listarSerie_NC_x_id($_POST['tipo_venta'], $id_serie);
                /*if($_POST['tipo_venta'] == "07"){
                    $series = $this->pedido->listarSerie_NC_factura($_POST['tipo_venta']);

                    if($tipo_documento_modificar == "01"){
                        $id =
                        $series = $this->pedido->listarSerie_NC_factura($_POST['tipo_venta']);
                    }else{
                        $series = $this->pedido->listarSerie($_POST['tipo_venta']);
                    }
                }else{

                }*/

                //$series = $this->pedido->listarSerie($_POST['tipo_venta']);
            }else{
                $correlativo_ = $this->serie->listar_correlativos_x_serie($_POST['id_serie']);
                $correlativo = $correlativo_->correlativo + 1;
            }
            //$series = $this->pedido->listarSerie($_POST['tipo_venta']);
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        $respuesta = array("serie" => $series, "correlativo" =>$correlativo);
        echo json_encode($respuesta);
    }

    public function tipo_nota_descripcion(){
        try{
            //$id_producto = $_POST['id_producto'];
            //$result = $this->pedido->listar_precio_producto($id_producto);
            $tipo_comprobante = $_POST['tipo_comprobante'];
            if($tipo_comprobante != ""){
                if($tipo_comprobante == "07"){
                    $dato_nota = $this->ventas->listar_descripcion_segun_nota_credito();
                    $nota = "Tipo Nota de Crédito";
                }else{
                    $dato_nota = $this->ventas->listar_descripcion_segun_nota_debito();
                    $nota = "Tipo Nota de Débito";
                }

                $nota_descripcion = "<label>".$nota."</label>";
                $nota_descripcion .= "<select class='form-control' id='notatipo_descripcion'>";
                foreach ($dato_nota as $dn){
                    $nota_descripcion.= "<option value='".$dn->codigo."'>".$dn->tipo_nota_descripcion."</option>";
                }
                $nota_descripcion .= "</select>";
            }

        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($nota_descripcion);
    }
}