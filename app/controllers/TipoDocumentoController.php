<?php

require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/TipoDocumento.php';

class TipoDocumentoController {
    private $rol;
    private $menu;

    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $modeltipodocumento;

    public function __construct() {
        //Instancias específicas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->modeltipodocumento = new TipoDocumento();
    }

    public function vista_listartipodocumento(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $tipodocumentos = $this->modeltipodocumento->mostrar_tipodocumentos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'tipodocumento/vista_listartipodoc.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function selecttipodocumentos() {
        $success = false;
        $message = "";
        $result = [];

        try{
            $result = $this->modeltipodocumento->mostrar_tipodocumentos();
            $message = "Listado correctamente.";
            $success = true;
        }catch (Exception $e){
            $message = $e->getMessage();
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        echo json_encode(
            array(
                "success" => $success,
                "message" => $message,
                "data" => $result
            )
        );
    }
}