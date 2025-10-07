<?php
/**
 * Created by PhpStorm
 * User: CARLOS MELENDEZ
 * Date: 05/08/2025
 * Time: 11:00
 */

require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Socios.php';
require 'app/models/Actividad.php';
require 'app/models/Categorias.php';
require 'app/models/facturacion/Clientes.php';
require 'app/models/fpdf/fpdf.php';
require 'app/models/TipoDocumentoSocio.php';
require 'app/models/BeneficioUsoSocio.php';
require 'app/models/Beneficios.php';

class SociosController{
    //Variables especificas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $socios;
    private $categorias;

    private $cliente;

    private $TipoDocumentoSocio;

    private $beneficios;
    private $beneficiosuso;


    public function __construct() {
        //Instancias específicas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->socios = new Socios();
        $this->categorias = new Categorias();
        $this->cliente = new Clientes();
        $this->TipoDocumentoSocio = new TipoDocumentoSocio();
        $this->beneficios = new Beneficios();
        $this->beneficiosuso = new BeneficioUsoSocio();
    }

    public function afiliacion() {
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $sectores = $this->socios->listar_sectores();

            $clientes = $this->cliente->listar_clientes();
            $beneficios = $this->beneficios->listar_beneficios();

            // Aseguramos que siempre llegue algo a la vista
            $datos = null;
            if(isset($_GET["id"])){
                $datos = $this->socios->detalle_afiliacion_socio($_GET["id"]);
            }

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'socios/afiliacion.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_afiliacion(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $socios = $this->socios->listar_socios();

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'socios/vista_afiliacion.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_detalle_afiliacion_socio(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $idsocio = $_GET['id'];

            $socios = $this->socios->detalle_afiliacion_socio($idsocio);
            $actividadsocios = $this->socios->listar_actividad_empresa_socio($idsocio);

//            $socios = $this->socios->detalle_afiliacion_socio($idsocio);
//            $actividadsocios = $this->socios->listar_actividad_empresa_socio($idsocio);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'socios/vista_detalle_afiliacion_socio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_detalle_beneficiousuo_socio(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $idsocio = $_GET['id'];
            $fecha  = date("Y-m-d H:i:s");

            $beneficios = $this->beneficios->listar_beneficios();
            $usoactual = $this->beneficiosuso->listar_beneficiouso_mesactual($idsocio, $fecha);
            //este codigo alimenta al acordion, tanto el título como sus tablas
            $resumen = $this->beneficiosuso->listar_uso_por_mes($idsocio);
            $detalle = $this->beneficiosuso->listar_detalle_uso($idsocio);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'socios/vista_detallebeneficios.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function obtener_datos_x_ruc(){
        //Array donde vamos a recetar los cambios, en caso hagamos alguno
        $cliente = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            $ruc = $_POST['numero_ruc'];
            $result = json_decode(file_get_contents('https://consultaruc.win/api/ruc/'.$ruc),true);
            $datos = array(
                'razon_social' => $result['result']['razon_social'],
                'estado' => $result['result']['estado'],
                'condicion' => $result['result']['condicion'],
            );

        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
            $result= [];
        }
        //Retornamos el json
        echo json_encode(array("result" => $datos));
    }

    public function generarpdf(){
        try{
            $id = $_GET["id"];
            $socios = $this->socios->detalle_afiliacion_socio($id);
            $actividadsocios = $this->socios->listar_actividad_empresa_socio($id);

            $pdf = new FPDF('P');
            $pdf->AddPage();

            //Cabezera del PDF
            $pdf->Image(__DIR__."/../../media/logo/logocamara.jpg", 10, 10, 60, 30);

            $pdf->Ln(10);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40, 5, "", 0, 0, '');
            $pdf->Cell(0,5,'FICHA DE INGRESO DE ASOCIADOS	',0,1,'C');

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(150, 5, "", 0, 0, '');
            $pdf->Cell(20, 5, "Iquitos, ", 0, 0, 'R');
            $pdf->Cell(20, 5, date('d/m/Y', strtotime($socios->socio_creacion)), 0, 1, 'R');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'IUB', 10);
            $pdf->Cell(0,5,'Datos Generales',0,0,'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 5, "RUC:", 0, 0, 'L');
            $pdf->Cell(0, 5, $socios->socio_num_ruc, 0, 0, 'l');

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 5, "Razón Social:", 0, 0, 'L');
            $pdf->Cell(0, 5, $socios->socio_razon_social, 0, 0, 'l');

            $pdf->Ln(5);
            $pdf->Cell(40, 5, "Nombre Comercial:", 0, 0, 'L');
            $pdf->Cell(0, 5, $socios->socio_nombre_comercial, 0, 0, 'l');

            $pdf->Ln(5);
            $pdf->Cell(40, 5, "Dirección:", 0, 0, 'L');
            $pdf->Cell(0, 5, $socios->socio_direccion, 0, 0, 'l');

            $pdf->Ln(5);
            $pdf->Cell(30, 5, "Departamento:", 0, 0, 'L');
            $pdf->SetFont('Arial', 'b', 10);
            $pdf->Cell(30, 5, $socios->socio_departamento, 0, 0, 'l');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, "Provincia:", 0, 0, 'c');
            $pdf->SetFont('Arial', 'b', 10);
            $pdf->Cell(50, 5, $socios->socio_provincia, 0, 0, 'c');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, "Distrito:", 0, 0, 'r');
            $pdf->SetFont('Arial', 'b', 10);
            $pdf->Cell(0, 5, $socios->socio_distrito, 0, 0, 'r');

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 5, "Fecha de Fundación:", 0, 0, 'L');
            $pdf->Cell(0, 5, date('d/m/Y', strtotime($socios->socio_fecha_fundacion)), 0, 0, 'L');

            $pdf->Ln(8);
            $pdf->Cell(25, 5, "Teléfonos:", 0, 0, 'l');
            $pdf->Cell(25, 5, $socios->socio_telefono1, 1, 0, 'l');
            $pdf->Cell(25, 5, $socios->socio_telefono2, 1, 0, 'l');

            $pdf->Cell(20, 5, "", 0, 0, 'L');
            $pdf->Cell(25, 5, "Celulares:", 0, 0, 'L');
            $pdf->Cell(30, 5, $socios->socio_celular1, 1, 0, 'l');
            $pdf->Cell(0, 5, $socios->socio_celular2, 1, 0, 'l');

            $pdf->Ln(8);
            $pdf->Cell(25, 5, "Página Web:", 0, 0, 'l');
            $pdf->Cell(75, 5, $socios->socio_pagina_web, 0, 0, 'l');
            $pdf->Cell(20, 5, "E-mail:", 0, 0, 'L');
            $pdf->Cell(0, 5, $socios->socio_correo, 0, 0, 'l');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'biu', 10);
            $pdf->Cell(50,5,'Principal ejecutivo',0,0,'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 5, "Apellidos y Nombres:", 0, 0, 'l');
            $pdf->Cell(100, 5, $socios->socio_nombre_ejecutivo, 0, 0, 'l');
            $pdf->Cell(20, 5, "Cargo:", 0, 0, 'R');
            $pdf->Cell(0, 5, $socios->socio_cargo_ejecutivo, 0, 0, 'C');

            $pdf->Ln(5);
            $pdf->Cell(30, 5, "Onomástico:", 0, 0, 'l');
            $pdf->Cell(40, 5, $socios->socio_ornomastico, 0);
            $pdf->Cell(20, 5, "Correo:", 0, 0, 'R');
            $pdf->Cell(0, 5, $socios->socio_email_ejecutivo, 0);

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'biu', 10);
            $pdf->Cell(0,5,'Descripción de la actividad',0,0,'L');

            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 10);
            $pdf->MultiCell(0, 5, $socios->socio_descripcion_actividad, 0);

            if(count($actividadsocios) > 0){
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'biu', 10);
                $pdf->Cell(0,5,'Actividad(es) de la Empresa',0,0,'L');
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'i', 10);

                foreach($actividadsocios as $actividad){
                    if($actividad->socio_actividad_id_socio == 1){
                        $pdf->Cell(36, 5, $actividad->actividad_nombre." (x)", 0, 0, 'C');
                    }

                    if($actividad->socio_actividad_id_socio == 2){
                        $pdf->Cell(36, 5, $actividad->actividad_nombre." (x)", 0, 0, 'C');
                    }

                    if($actividad->socio_actividad_id_socio == 3){
                        $pdf->Cell(36, 5, $actividad->actividad_nombre." (x)", 0, 0, 'C');
                    }

                    if($actividad->socio_actividad_id_socio == 4){
                        $pdf->Cell(36, 5, $actividad->actividad_nombre." (x)", 0, 0, 'C');
                    }

                    if($actividad->socio_actividad_id_socio == 5){
                        $pdf->Cell(36, 5, $actividad->actividad_nombre." (x)", 0, 0, 'C');
                    }
                }
            }

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'bu', 10);
            $pdf->Cell(100, 5, "Detalle de la categoría", 0, 0, 'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(30, 5, "Código: ".$socios->id_socio, 0, 0, 'L');
            $pdf->Cell(30, 5, "Categoría: ".$socios->categoria_nombre, 0, 0, 'L');
            $pdf->Cell(50, 5, "Cuota Ingreso: S/. ".$socios->categoria_inscripcion, 0, 0, 'L');
            $pdf->Cell(50, 5, "Cuota Mensual: S/. ".$socios->categoria_cuota, 0, 0, 'L');
            $pdf->Cell(0, 5, "Tipo Pago: ".$socios->socio_tipo_pago, 0, 0, 'R');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'bi', 10);
            $pdf->Cell(0,5,'Declaramos que la información que figura en esta solicitud expresa la verdad',0,0,'L');

            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(100, 5, "Representante de la empresa afiliada a la CCITL", 1, 0, 'C');
            $pdf->Cell(50, 5, "Cargo", 1, 0, 'C');
            $pdf->Cell(0, 5, "Sello/Firma", 1, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(100, 20, "", 1, 0, 'C');
            $pdf->Cell(50, 20, "", 1, 0, 'C');
            $pdf->Cell(0, 20,"", 1, 0, 'C');

            //Firma
            $pdf->Ln(40);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(100, 20, "__________________________", 0, 0, 'C');
            $pdf->Cell(80, 20, "__________________________", 0, 0, 'C');

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(100, 20, "Gerencia V.B", 0, 0, 'C');
            $pdf->Cell(80, 20, "Secretaria - Atención al asociado", 0, 0, 'C');


            $pdf->Output();
            exit;
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            http_response_code(500);
            echo 'Error generando PDF demo: '.$e->getMessage();
        }
    }

    public function rubro_por_sector(){
        $result = [];
        try{
            $result = $this->socios->listar_rubro_x_sector($_POST['id_sector']);
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        echo json_encode($result);
    }

    public function guardar_socio() {
        $result = 0;
        $message = 'OK';
        $ruta_guardado = "";

        try{
            $ruta_guardado = "";
            $modelsocios = new Socios();
            $modelosocioactividad = new Actividad();

            if(!isset($_POST['id_cliente'])){
                throw new Exception("Ocurrió un Error, el cliente no fue enviando");
            }

            // PROCESAR documento Expediente
            if(empty($_FILES)){
                throw new Exception("No hay archivos");
            }

            /* REGISTRO DEL CLIENTE */
            $idcliente = $_POST['id_cliente'] ?? "0";
            $this->cliente->cliente_tipopersona = $_POST['empresa_tipo'];
            $this->cliente->id_tipodocumento = 4;
            $this->cliente->cliente_numero = $_POST['empresa_ruc'];
            $this->cliente->cliente_razonsocial = $_POST['empresa_razonsocial'];
            $this->cliente->cliente_nombre = "";
            $this->cliente->cliente_correo = $_POST['empresa_email'];
            $this->cliente->cliente_celular1 = $_POST['empresa_celular1'];
            $this->cliente->cliente_celular2 = $_POST['empresa_celular2'];
            $this->cliente->cliente_telefono1 = $_POST['empresa_telefono1'];
            $this->cliente->cliente_telefono2 = $_POST['empresa_telefono2'];
            $this->cliente->cliente_direccion = $_POST['empresa_direccion'];
            $this->cliente->cliente_fecha = $_POST['socio_creacion'];

            if($idcliente !== "0") {
                $this->cliente->id_cliente = $idcliente;
            }

            $existesocio = $this->socios->existe_socio_con_idcliente($_POST['id_cliente']);
            if($existesocio){
                throw new Exception("Ya existe un socio registrado");
            }

            $idcliente = $this->cliente->guardar($this->cliente);
            if(!empty($_POST['id_socio'])){
                $modelsocios->id_socio = $_POST['id_socio'];
                throw new Exception("No se puede guardar el Socio, id_socio no existe");
            }

            $this->socios->socio_id_cliente = $idcliente;
            $this->socios->socio_nombre_comercial = $_POST['empresa_nombre'];
            $this->socios->socio_departamento  =$_POST['selectDepartamento'];
            $this->socios->socio_provincia = $_POST['selectProvincia'];
            $this->socios->socio_distrito = $_POST['selectDistrito'];
            $this->socios->socio_sector = $_POST['empresa_sector'];
            $this->socios->socio_rubro = $_POST['id_rubro'];
            $this->socios->socio_fecha_fundacion = $_POST['empresa_fundacion'];
            $this->socios->socio_descripcion_actividad = $_POST['empresa_descripcion'];
            $this->socios->socio_pagina_web = $_POST['empresa_paginaweb'];
            $this->socios->socio_nombre_ejecutivo = $_POST['empresa_apellidos'];
            $this->socios->socio_cargo_ejecutivo = $_POST['idinputcargoafiliado'];
            $this->socios->socio_ornomastico = $_POST['idinput_ornomasticoafiliado'];
            $this->socios->socio_email_ejecutivo = $_POST['idinput_emailejecutivo'];
//            $this->socios->socio_id_beneficio = $_POST['id_beneficio'];
            $this->socios->socio_id_categoria = $_POST['idselect_categoriaafiliado'];
            $this->socios->socio_tipo_pago = $_POST['idselecttipopago'];
            $this->socios->socio_creacion = $_POST['socio_creacion'];


            $resultfoto = $this->socios->almacenarfotoempresa($_FILES, [
                "empresa_razonsocial" => $_POST['empresa_razonsocial']
            ]);
            if(!$resultfoto["success"]){
                throw new Exception($resultfoto["message"]);
            }

            $this->socios->socio_rutalogo = $resultfoto["data"][0]["ruta"];
            $idsocio = $modelsocios->guardar_socio($this->socios);
            if ($idsocio !== 0 && !empty($_POST['actividades'])) {
                $actividades = $_POST['actividades']; // Esto es un array
                for ($i = 0; $i < count($actividades); $i++) {
                    $modelosocioactividad->socio_actividad_id_socio = $idsocio;
                    $modelosocioactividad->socio_actividad_id_actividad = $actividades[$i];
                    $modelosocioactividad->socio_actividad_creacion = $_POST['socio_creacion'];
                    $result = $modelosocioactividad->guardar_socio_actividad($modelosocioactividad);
                }
            }

            $documentosresult = $this->socios->guardar_documentos_expediente($_FILES, [
                "empresa_razonsocial" => $_POST['empresa_razonsocial'],
                "id_socio" => $idsocio
            ]);
            if(!$documentosresult["success"]){
                throw new Exception($documentosresult["message"]);
            }

            //Registramos en la tabla TiPODocsocio sus documentos
            foreach ($documentosresult["data"] as $doc) {
                $this->TipoDocumentoSocio->sociodocumento_tipodocsocio = $doc["id"];
                $this->TipoDocumentoSocio->sociodocumento_idsocio = $idsocio;
                $this->TipoDocumentoSocio->sociodocumento_nombrearchivo = $doc["nombre"];
                $this->TipoDocumentoSocio->sociodocumento_rutaarchivo = $doc["ruta"];
                $this->TipoDocumentoSocio->sociodocumento_fecha = $_POST['socio_creacion'];
                $result2 = $this->TipoDocumentoSocio->guardar_TipoDocumentoSocio($this->TipoDocumentoSocio);
                if($result2 !== 1) throw new Exception("No se registro los Documentos en la BD.");
            }

            $result = 1;
        }
        catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        finally {
            //Retornamos el json
            echo json_encode(
                array(
                    "result" => array(
                        "code" => $result,
                        "message" => $message,
                        'url'=>$ruta_guardado
                    )
                )
            );
        }
    }
}