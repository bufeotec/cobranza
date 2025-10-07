<?php
/**
 * Created by PhpStorm
 * User: CARLOS MELENDEZ
 * Date: 05/08/2025
 * Time: 11:00
 */

require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Categorias.php';
class CategoriasController{
    //Variables especificas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $categorias;
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
        $this->categorias = new Categorias();
    }

    public function categorias(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $categorias = $this->categorias->listar_categorias();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'categorias/categorias.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function guardar_categoria(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('categoria_nombre', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_categoria', 'POST',false,$ok_data,11,'numero',0);
            if($ok_data){
                $model = new Categorias();
                if(!empty($_POST['id_categoria'])){
                    $model->id_categoria = $_POST['id_categoria'];
                    $validar_duplicados = $this->categorias->buscar_categoria_nombre_e(ucfirst(strtolower($_POST['categoria_nombre'])),$_POST['id_categoria']);
                } else {
                    $validar_duplicados = $this->categorias->buscar_categoria_nombre(ucfirst(strtolower($_POST['categoria_nombre'])));
                }
                if($validar_duplicados){
                    $result = 3;
                    $message = "Ya existe una categoría registrado";
                } else {

                    $model->categoria_nombre = $_POST['categoria_nombre'];
                    $model->categoria_cuota = $_POST['categoria_cuota'];
                    $model->categoria_inscripcion = $_POST['categoria_inscripcion'];
                    $model->categoria_cuota_anual = $_POST['categoria_cuota_anual'];
                    $model->categoria_horas_auditorio = $_POST['categoria_horas_auditorio'];
                    $model->categoria_estado = $_POST['categoria_estado'];
                    $model->categoria_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                    $result = $this->categorias->guardar_categoria($model);
                }
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_categoria_select() {
        $result = [];
        try{
            $result = $this->categorias->listar_categorias_select();
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        echo json_encode($result);
    }
}

