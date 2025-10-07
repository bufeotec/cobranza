<?php
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Reporte.php';

class ReporteController {
    //Variables específicas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $reporte;

    public function __construct() {
        //Instancias específicas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->reporte = new Reporte();
    }

    public function vista_listarareporte(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'Reporte/vista_verreporte.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
}