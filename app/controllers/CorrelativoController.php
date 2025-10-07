<?php
/**
 * Created by PhpStorm.
 * User: Lucho
 * Date: 31/08/2020
 * Time: 23:20
 */
require 'app/models/facturacion/Correlativo.php';
//require 'app/models/Active.php';

class CorrelativoController
{
    private $encriptar;
    private $menu;
    private $log;
    private $validar;
    private $nav;
    private $correlativo;

    public function __construct()
    {
        $this->encriptar = new Encriptar();
        //$this->menu = new Menu();
        $this->log = new Log();
        $this->correlativo = new Correlativo();
        $this->validar = new Validar();

    }

    public function editar(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $correlativo = $this->correlativo->listar();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'correlativo/editar.php';
            require _VIEW_PATH_ . 'footer.php';

        }catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES
    public function editar_c(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_correlativo', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_b', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_f', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_in', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_out', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_nc', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_nd', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('correlativo_venta', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data){
                $model = new Correlativo();
                $model->id_correlativo = $_POST['id_correlativo'];
                $model->correlativo_b = $_POST['correlativo_b'];
                $model->correlativo_f = $_POST['correlativo_f'];
                $model->correlativo_in = $_POST['correlativo_in'];
                $model->correlativo_out = $_POST['correlativo_out'];
                $model->correlativo_nc = $_POST['correlativo_nc'];
                $model->correlativo_nd = $_POST['correlativo_nd'];
                $model->correlativo_venta = $_POST['correlativo_venta'];

                $result = $this->correlativo->guardar_edicion($model);

            }  else {
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
}