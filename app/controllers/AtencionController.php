<?php
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Atencion.php';

class AtencionController {
    //Variables específicas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $atencion;


    public function __construct() {
        //Instancias específicas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->atencion = new Atencion();
    }

    public function vista_listaratenciones(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $atencion = $this->atencion->mostrar_listaatencion();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'atencion/vista_listaratencion.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function guardar_atencion() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            if($_POST['idatencion'] != 0){
                $this->atencion->id_atencion = $_POST['idatencion'];
            }
//            else{
//                $existe_categoriaBeneficios = $this->atencion->existe_beneficioscategoria_con_idcategoria($_POST['idcategoria'], $_POST['idbeneficio']);
//                if($existe_categoriaBeneficios){
//                    throw new Exception("Ya existe una categoria asociada a este beneficio");
//                }
//            }

            $this->atencion->atencion_dni =$_POST['dni'];
            $this->atencion->atencion_nombre = $_POST['nombre'];
            $this->atencion->atencion_area = $_POST['area'];
            $this->atencion->atencion_motivo = $_POST['motivo'];
            $this->atencion->atencion_observacion = $_POST['observacion'];
            $this->atencion->atencion_fecha = $_POST['fecha'];
            $idatencion = $this->atencion->registrar_atencion($this->atencion);
            if($idatencion === 0){
                throw new Exception("Ocurrió un Error al Guardar la Atencion");
            }

            $success = true;
            $message = "Se ha Guardado la Atencion correctamente.";
        }
        catch (Throwable $e){
            $message = $e->getMessage();
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        finally {
            echo json_encode(
                array(
                    "result" => array(
                        "code" => $code,
                        "success" => $success,
                        "message" => $message
                    )
                )
            );
        }
    }

    public function eliminar_atencion() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $idatencion = $_POST['idatencion'];
            $success = $this->atencion->eliminar_atencion($idatencion);
            if(!$success){
                throw new Exception("Ocurrió un error al eliminar el uso del Atencion.");
            }

            $message = "Atencion eliminado correctamente.";
        }
        catch (Throwable $e){
            $message = $e->getMessage();
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        finally {
            echo json_encode(
                array(
                    "result" => array(
                        "code" => $code,
                        "success" => $success,
                        "message" => $message
                    )
                )
            );
        }
    }
}