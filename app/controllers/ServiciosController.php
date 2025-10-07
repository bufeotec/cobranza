<?php
/**
 * Created by PhpStorm
 * User: CARLOS MELENDEZ
 * Date: 05/08/2025
 * Time: 11:00
 */

require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Servicios.php';
class ServiciosController{
    //Variables especificas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $servicios;
    public function __construct()
    {
        //Instancias especificas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->servicios = new Servicios();
    }

    //Vistas/Opciones
    //Vista de Inicio de La Gestión de Menús
    public function servicios(){
        try{

            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            //Traemos los roles registrados
            $servicios = $this->servicios->listar_servicios_todos();
            $serv_cat = $this->servicios->listar_servicios_categoria();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'servicios/servicios.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function guardar_servicio(){
        $servicio = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('servicio_nombre', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('servicio_descripcion', 'POST',true,$ok_data,500,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_servicio', 'POST',false,$ok_data,11,'numero',0);
            if($ok_data){
                $model = new Servicios();
                if(!empty($_POST['id_servicio'])){
                    $model->id_servicio = $_POST['id_servicio'];
                    $validar_duplicados = $this->servicios->buscar_servicio_nombre_e(ucfirst(strtolower($_POST['servicio_nombre'])),$_POST['id_servicio']);
                } else {
                    $validar_duplicados = $this->servicios->buscar_servicio_nombre(ucfirst(strtolower($_POST['servicio_nombre'])));
                }
                if($validar_duplicados){
                    $result = 3;
                    $message = "Ya existe un servicio registrado";
                } else {
                    $model->id_servicios_categoria = $_POST['id_servicios_categoria'];
                    $model->servicio_nombre = $_POST['servicio_nombre'];
                    $model->servicio_descripcion = $_POST['servicio_descripcion'];
                    $model->servicio_precio_normal = $_POST['servicio_precio_normal'];
                    $model->servicio_precio_socio = $_POST['servicio_precio_socio'];
                    $model->servicio_estado = $_POST['servicio_estado'];
                    $model->id_servicio_tipo_afectacion = $_POST['id_servicio_tipo_afectacion'];
                    $model->servicio_idmedida = 59;
                    $model->servicio_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $result = $this->servicios->guardar_servicio($model);
                    if($result == 1) {
                        if(!empty($_POST['id_servicio'])){
                            $servicio = array(
                                "id_servicio" => $_POST['id_servicio'],
                                "id_servicios_categoria" => $_POST['id_servicios_categoria'],
                                "servicio_nombre" => $_POST['servicio_nombre'],
                                "servicio_descripcion" => $_POST['servicio_descripcion'],
                                "servicio_precio_normal" => $_POST['servicio_precio_normal'],
                                "servicio_precio_socio" => $_POST['servicio_precio_socio'],
                                "servicio_estado" => $_POST['servicio_estado'],
                                "servicio_tipoafectacion" => $_POST['id_servicio_tipo_afectacion']
                            );
                        }
                    }
                }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "servicio" => $servicio)));
    }

    public function buscar_servicio_nombreycodigo() {
        $result = 0;
        $success = false;
        $message = 'OK';

        try {
            $buscar = $_POST['query'];
            $datos = $this->servicios->buscar_servicio_x_nombre_y_codigo($buscar);
            $success = true;
        }
        catch (Exception $e){
            $message = $e->getMessage();
            $datos = [];
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        finally{
            //Retornamos el json
            echo json_encode(
                array(
                    "result" => array(
                        "code" => $result,
                        "message" => $message,
                        "success" => $success,
                        "data" => $datos
                    )
                )
            );
        }
    }
}

