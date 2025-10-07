<?php
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Evento.php';
require 'app/models/EventoAsist.php';
require 'app/models/Socios.php';

class EventoController {
//Variables específicas del controlador
    private $rol;
    private $menu;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $evento;
    private $eventoAsis;
    private $socios;

    public function __construct() {
        //Instancias específicas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->evento = new Evento();
        $this->eventoAsis = new EventoAsist();
        $this->socios = new Socios();
    }

    public function vista_listareventos(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $eventos = $this->evento->mostrar_listaeventos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'eventos/vista_listareventos.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_listareventosasist(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $idevento = $_GET['id'];
            $eventoasistlist = $this->eventoAsis->mostrar_listaeventosasist($idevento);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'eventos/vista_listareventosasist.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function guardar_evento() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            if($_POST['idevento'] != 0){
                $this->evento->id_evento = $_POST['idevento'];
            }
//            else{
//                $existe_categoriaBeneficios = $this->atencion->existe_beneficioscategoria_con_idcategoria($_POST['idcategoria'], $_POST['idbeneficio']);
//                if($existe_categoriaBeneficios){
//                    throw new Exception("Ya existe una categoria asociada a este beneficio");
//                }
//            }

            $this->evento->evento_nombre = $_POST['evento_nombre'];
            $this->evento->evento_fecha = $_POST['fecha'];
            $this->evento->evento_estado = $_POST['evento_estado'];
            $idevento = $this->evento->registrar_eventos($this->evento);
            if($idevento === 0){
                throw new Exception("Ocurrió un Error al Guardar el evento");
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

    public function guardar_eventoasit() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $this->eventoAsis->eventoasist_fecha = $_POST['fecha'];
            $this->eventoAsis->eventoasist_hora = date("H:i:s", strtotime($_POST['fecha']));
            if($_POST['ideventoasist'] == 0){
                $this->eventoAsis->eventoasist_idsocio = $_POST['idsocio'];
                $this->eventoAsis->eventoasist_idevento = $_POST['idevento'];
                $ideventoasist = $this->eventoAsis->registrar_eventosasit($this->eventoAsis);
            }
            else{
                $this->eventoAsis->id_eventoasist = $_POST['ideventoasist'];
                $ideventoasist = $this->eventoAsis->cambiarestado_eventosasit(
                    $this->eventoAsis->id_eventoasist,
                    $this->eventoAsis->eventoasist_fecha,
                    $this->eventoAsis->eventoasist_hora
                );
            }

            if($ideventoasist === 0){
                throw new Exception("Ocurrió un Error al Guardar la Asistencia a este evento");
            }

            $success = true;
            $message = "Se ha Guardado la Asistencia al Evento.";
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

    public function eliminar_eventoasit() {
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

    public function eliminar_evento() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $idevento = $_POST['idevento'];
            $success = $this->evento->cambiarestado_eventos($idevento, 0);
            if(!$success){
                throw new Exception("Ocurrió un error al eliminar el Evento");
            }

            $message = "Evento eliminado correctamente.";
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