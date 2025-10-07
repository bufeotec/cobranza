<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 2/09/2025
 * Time: 12:29
 */
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Categorias.php';
require 'app/models/Socios.php';
require 'app/models/facturacion/Clientes.php';
require 'app/models/facturacion/Ventas.php';
require 'app/models/facturacion/VentaDetalle.php';
require 'app/models/Servicios.php';
require 'app/models/Serie.php';
require 'app/models/facturacion/GeneradorXML.php';
require 'app/models/facturacion/ApiFacturacion.php';
require 'app/models/facturacion/Nmletras.php';
require 'app/models/facturacion/VentaCuotas.php';
require 'app/models/Cobranza.php';

class CobranzaController{
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
    private $categorias;
    private $cobranza;
    private $socio;

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
        $this->categorias = new Categorias();
        $this->cobranza = new Cobranza();
        $this->socio = new Socios();
    }

    public function cobranza(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $categorias = $this->categorias->listar_categorias();
            $facturar = false;
            $id_categoria_socio =  "";
            $mes =  date('m');
            $anio =  date('Y');
            $clientes = [];
            $_SESSION['pagos'] = [];
            if(!empty($_GET['id_categoria_socio']) && !empty($_GET['mes']) && !empty($_GET['anio'])){
                $facturar = true;
                $clientes = $this->cobranza->listar_socios_facturacion_filtrado($_GET['id_categoria_socio'], intval($_GET['anio']), intval($_GET['mes']));

                $id_categoria_socio = $_GET['id_categoria_socio'];
                $mes = $_GET['mes'];
                $anio = $_GET['anio'];
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'cobranza/cobranza.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function listar(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $categorias = $this->categorias->listar_categorias();
            $socios = $this->socio->listar_socios_activos();
            $facturar = true;
            $id_categoria_socio =  "";
            $id_socio =  "";
            $mes =  date('m');
            $anio =  date('Y');
            $estado =  "";

            $query =  "";

            if(isset($_GET['id_categoria_socio']) && isset($_GET['mes']) && isset($_GET['anio']) && isset($_GET['estado'])){
                $id_categoria_socio = $_GET['id_categoria_socio'];
                $mes = $_GET['mes'];
                $anio = $_GET['anio'];
                $estado = $_GET['estado'];
                $id_socio = $_GET['id_socio'];
            }

            $condiciones = [];

            if (!empty($id_categoria_socio)) {
                $condiciones[] = "c.id_categoria = '" . $id_categoria_socio . "'";
            }

            if (!empty($id_categoria_socio)) {
                $condiciones[] = "c.id_categoria = '" . $id_categoria_socio . "'";
            }

            if (!empty($mes)) {
                $condiciones[] = "c.cobranza_mes = '" . $mes . "'";
            }

            if (!empty($anio)) {
                $condiciones[] = "c.cobranza_anho = '" . $anio . "'";
            }

            if (!empty($estado)) {
                $condiciones[] = "c.cobranza_estado = '" . $estado . "'";
            }

            $query = "";
            if (!empty($condiciones)) {
                $query = " WHERE " . implode(" AND ", $condiciones);
            }
            $clientes = $this->cobranza->listar_socios_facturados($query);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'cobranza/listar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function generar_cobranza()
    {
        try{
            $message = "We did it. Your awesome... and beatiful";
            $result = 2;
            $model = new Cobranza();
            $ok_data = true;
            if($ok_data){
                $model->id_categoria_socio = $_POST['id_categoria_socio'];
                $model->mes = $_POST['mes'];
                $model->anio = $_POST['anio'];
                // Aca va el codigo para generar la cobranza
                $categoria = $this->categorias->listar_categoria_id($_POST['id_categoria_socio']);
                $mes_concepto = $this->cobranza->mes_en_espanol_mayus($_POST['mes']);
                $descripcion_concepto = "CUOTA ORDINARIA MES DE ".$mes_concepto . " " . $_POST['anio'] ." - CATEGORIA " . $categoria->categoria_nombre;
                $monto_concepto = $categoria->categoria_cuota;
                foreach ($_SESSION['pagos'] as $socio){
                    if($socio['cobrar'] == 1){
                        $serie = $this->servicios->listar_serie(1);
                        $serie->correlativo = $serie->correlativo + 1;

                        $_POST['id_cliente'] = $socio['id_cliente'];
                        $_POST['id_tipo_pago'] = $socio['tipo_pago'];
                        $_POST['venta_tipo_moneda'] = 1;
                        $_POST['venta_tipo_envio'] = 1;
                        $_POST['venta_tipo'] = "01";
                        $_POST['venta_serie'] = $serie->serie;
                        $_POST['venta_correlativo'] = $serie->correlativo;
                        $_POST['producto_venta_des_global'] = 1;
                        $_POST['venta_totalexonerada'] = $monto_concepto;
                        $_POST['producto_venta_totainafecta'] = 1;
                        $_POST['producto_venta_totaligv'] = 1;
                        $_POST['venta_total'] = $monto_concepto;
                        $_POST['venta_fecha'] = date('Y-m-d H:i:s');
                        $_POST['tipo_documento_modificar'] = null;
                        $_POST['venta_forma_pago'] = 1;
                        /*$_POST['detalle_venta'] = new stdClass();
                        $payload = (object)[
                            'id_servicio'    => 1,
                            'venta_detalle_valor_total' => $monto_concepto
                        ];
                        $_POST['detalle_venta'][] = $payload;*/

                        //Aca se genera la factura cada socio
                        $idusuario = $this->encriptar->desencriptar($_SESSION['c_u'], _FULL_KEY_);
                        $this->ventas->id_empresa               = 1;
                        $this->ventas->id_usuario               = $idusuario;
                        $this->ventas->id_cliente               = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
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
                        $this->ventas->venta_observacion        = isset($_POST['venta_observacion']) ? $_POST['venta_observacion'] : null;
                        $this->ventas->tipo_documento_modificar = isset($_POST['tipo_documento_modificar']) ? $_POST['tipo_documento_modificar'] : null;
                        $this->ventas->serie_modificar          = isset($_POST['serie_modificar']) ? $_POST['serie_modificar'] : null;
                        $this->ventas->correlativo_modificar    = isset($_POST['correlativo_modificar']) ? $_POST['correlativo_modificar'] : null;
                        $this->ventas->venta_codigo_motivo_nota = isset($_POST['venta_codigo_motivo_nota']) ? $_POST['venta_codigo_motivo_nota'] : null;
                        $this->ventas->venta_estado_sunat       = isset($_POST['venta_estado_sunat']) ? $_POST['venta_estado_sunat'] : 0;
                        $this->ventas->venta_fecha_envio        = isset($_POST['venta_fecha_envio']) ? $_POST['venta_fecha_envio'] : null;
                        $this->ventas->venta_rutaXML            = isset($_POST['venta_rutaXML']) ? $_POST['venta_rutaXML'] : null;
                        $this->ventas->venta_rutaCDR            = isset($_POST['venta_rutaCDR']) ? $_POST['venta_rutaCDR'] : null;
                        $this->ventas->venta_respuesta_sunat    = isset($_POST['venta_respuesta_sunat']) ? $_POST['venta_respuesta_sunat'] : null;
                        $this->ventas->venta_fecha_de_baja      = isset($_POST['venta_fecha_de_baja']) ? $_POST['venta_fecha_de_baja'] : null;
                        $this->ventas->anulado_sunat            = isset($_POST['anulado_sunat']) ? $_POST['anulado_sunat'] : 0;
                        $this->ventas->venta_cancelar           = isset($_POST['venta_cancelar']) ? $_POST['venta_cancelar'] : 1;

                        //$formapago = isset($socio['forma_pago']) ? $socio['forma_pago'] : "1";
                        $this->ventas->venta_forma_pago = $socio['forma_pago'] == "1" ? "CONTADO" : "CREDITO";
                        //$this->ventas->venta_forma_pago = $socio['forma_pago'];

                        $idventa = $this->ventas->guardar_venta($this->ventas);
                        if($idventa == 0){
                            throw new Exception('Error al Generar la Venta');
                        }

                        if($socio['forma_pago'] == 2){
                            $ultimoDia = date("Y-m-t", mktime(0, 0, 0, intval($_POST['mes']), 1, intval($_POST['anio'])));
                            $this->ventas->id_ventas = $idventa;
                            $this->ventas->id_tipo_pago  = $socio['tipo_pago'];
                            $this->ventas->venta_cuota_numero = 1;
                            $this->ventas->venta_cuota_importe = $monto_concepto;
                            $this->ventas->venta_cuota_fecha = $ultimoDia;
                            $this->ventas->venta_cuota_datetime = $this->ventas->venta_fecha;
                            $this->ventacuota->guardar_detalle_cuota($this->ventas);
                        }

                        $this->ventadetalle->id_venta = $idventa;
                        $this->ventadetalle->id_servicio  = 1;
                        if(empty($socio['descripcion'])){
                            $this->ventadetalle->venta_detalle_descripcion  = $descripcion_concepto;
                        } else {
                            $this->ventadetalle->venta_detalle_descripcion  = $socio['descripcion'];
                        }
                        $this->ventadetalle->venta_detalle_cantidad  = 1;
                        $this->ventadetalle->venta_detalle_total_igv = 0;
                        $this->ventadetalle->venta_detalle_precio_unitario = $monto_concepto;
                        $this->ventadetalle->venta_detalle_valor_total = $monto_concepto;
                        $this->ventadetalle->venta_detalle_porcentaje_igv = 0;
                        $result = $this->ventadetalle->guardar_detalle_venta($this->ventadetalle);
                        if($result == 1){
                            $model = new Cobranza();
                            $model->id_socio = $socio['id_socio'];
                            $model->id_categoria = $_POST['id_categoria_socio'];
                            $model->cobranza_anho = intval($_POST['anio']);
                            $model->cobranza_mes = intval($_POST['mes']);
                            $ultimaFecha = date("Y-m-t", mktime(0, 0, 0, intval($_POST['mes']), 1, intval($_POST['anio'])));
                            $model->cobranza_fecha_vencimiento = $ultimaFecha;
                            $model->cobranza_monto = $monto_concepto;
                            $model->cobranza_monto_cobrado = $monto_concepto;
                            $model->id_venta = $idventa;
                            $model->cobranza_estado = 0;
                            $this->cobranza->insertar_cobranza($model);
                        }
                        //actualizo el correlativo
                        $modeloserie = new Serie();
                        $modeloserie->actualizarcorrelativo($this->ventas->venta_serie);
                        $this->crear_tiket($idventa);
                    } else {
                        $result = 1;
                    }
                }
                if($result == 1){
                    $message = "Cobranza generada correctamente.";
                } else if ($result == 6){
                    $message = "Code 6: Fail Data Integrity";
                } else {
                    $message = "No se pudo generar la cobranza.";
                }
            } else {
                $result = 6; $message = "Code 6: Fail Data Integrity";
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2; $message = "Code 2: General Error";
        }
        if($result == 1){
            unset($_SESSION['pagos']);
        }
        $response = array("code" => $result, "message" => $message);
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function actualizar_cobrito(){
        try{
            if(isset($_POST['id']) && isset($_POST['cobrar'])){
                $_SESSION['pagos'][$_POST['id']]['cobrar'] = intval($_POST['cobrar']);
                $_SESSION['pagos'][$_POST['id']]['tipo_pago'] = intval($_POST['tipo_pago']);
                $_SESSION['pagos'][$_POST['id']]['forma_pago'] = intval($_POST['forma_pago']);
                $_SESSION['pagos'][$_POST['id']]['descripcion'] = $_POST['descripcion'];
                $result = 1;
            } else {
                $result = 2;
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        echo json_encode($result);
    }

    public function crear_tiket($idventa): bool {
        //INICIO - LISTAR COLUMNAS PARA TICKET DE VENTA
        include_once('libs/ApiFacturacion/phpqrcode/qrlib.php');
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

    public function listar_comprobantes() {
        try {
            if (!empty($_POST['id_cobranza'])) {
                $result = $this->cobranza->listar_comprobantes_cobranza($_POST['id_cobranza']);
                if(count($result) >= 1){
                    foreach ($result as $rt){
                        $rutita = explode('/', $rt->comprobante_ruta);
                        $rt->comprobante_ruta_descarga = $rutita[2];
                    }
                }
            } else {
                $result = array('message' => "ID de cobranza no proporcionado.");
            }
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = array('message' => "Error al obtener los comprobantes: " . $e->getMessage());
        }
        echo json_encode(array("result" => $result));
    }

    public function guardar_comprobante() {
        $result = 2;
        $message = 'Error al guardar el comprobante';

        try {
            $ok_data = true;
            //$ok_data = $this->validar->validar_parametro('comprobante_descripcion', 'POST', true, $ok_data, 255, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('id_cobranza_b', 'POST', true, $ok_data, 11, 'numero', 0);
            if ($ok_data) {
                $id_cobranza = $_POST['id_cobranza_b'];
                $descripcion = "archivo_comprobante";
                if (!empty($_FILES['comprobante_ruta']['name'])) {
                    $ext = pathinfo($_FILES['comprobante_ruta']['name'], PATHINFO_EXTENSION);
                    $file_path = "media/comprobantes/" . $descripcion . "_" . date('dmYHis') . "." . $ext;
                    if (!move_uploaded_file($_FILES['comprobante_ruta']['tmp_name'], $file_path)) {
                        $file_path = null;
                    }
                } else {
                    $file_path = null;
                }
                $model = new Cobranza();
                $model->id_cobranza = $id_cobranza;
                $model->comprobante_descripcion = null;
                $model->comprobante_ruta = $file_path;
                $model->comprobante_monto = $_POST['comprobante_monto'];
                $model->comprobante_fecha = $_POST['comprobante_fecha'];
                $model->comprobante_estado = 1;
                $result = $this->cobranza->insertar_comprobante_cobranza($model);
            } else {
                $result = 6;
                $message = "Parámetros enviados incorrectos";
            }
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        if($result == 1){
            $cobranza_actual = $this->cobranza->listar_cobranza_id($_POST['id_cobranza_b']);
            $total_adjuntado = $this->cobranza->sumar_monto_comprobantes($_POST['id_cobranza_b']);

            if($cobranza_actual->cobranza_monto_cobrado <= $total_adjuntado->monto){
                $this->cobranza->actualizar_estado_cobranza($_POST['id_cobranza_b'], 1);
            } else {
                $this->cobranza->actualizar_estado_cobranza($_POST['id_cobranza_b'], 0);
            }
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function eliminar_comprobante() {
        $result = 2;
        $message = 'Error al eliminar comprobante';

        try {
            if (!empty($_POST['id_comprobante_cob'])) {
                $result = $this->cobranza->eliminar_comprobantes_cobranza($_POST['id_comprobante_cob']);
                if ($result == 1) {
                    $message = 'Comprobante eliminado correctamente';

                    $cobranza_actual = $this->cobranza->listar_cobranza_id($_POST['id_cobranza_b']);
                    $total_adjuntado = $this->cobranza->sumar_monto_comprobantes($_POST['id_cobranza_b']);

                    if($cobranza_actual->cobranza_monto_cobrado <= $total_adjuntado->monto){
                        $this->cobranza->actualizar_estado_cobranza($_POST['id_cobranza_b'], 1);
                    } else {
                        $this->cobranza->actualizar_estado_cobranza($_POST['id_cobranza_b'], 0);
                    }
                } else {
                    $message = 'Error al actualizar el estado del comprobante';
                }
            } else {
                $message = 'ID de comprobante no válido';
            }
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
}