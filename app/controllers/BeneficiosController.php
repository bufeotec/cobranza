<?php

require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Beneficios.php';
require 'app/models/CategoriaBeneficios.php';
require 'app/models/Categorias.php';
require 'app/models/TipoBeneficios.php';
require 'app/models/BeneficioUsoSocio.php';
require 'app/models/Socios.php';

class BeneficiosController {
    private $rol;
    private $menu;

    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $beneficios;
    private $categoriaBeneficios;

    private $categorias;
    private $tipobeneficios;
    private $socio;
    private $beneficiousosocio;


    public function __construct() {
        //Instancias específicas del controlador
        $this->rol = new Rol();
        $this->menu = new Menu();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->beneficios = new Beneficios();
        $this->categoriaBeneficios = new CategoriaBeneficios();
        $this->categorias = new Categorias();
        $this->tipobeneficios = new TipoBeneficios();
        $this->beneficiousosocio = new BeneficioUsoSocio();
        $this->socio = new Socios();
    }

    public function vista_beneficios(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $tipobeneficios = $this->tipobeneficios->listar_TipoBeneficio();
            $beneficios = $this->beneficios->listar_beneficios();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'beneficios/vista_beneficios.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_detallebeneficios(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $id_beneficio = $_GET['id'];

            $categoria = $this->categorias->listar_categorias();
            $beneficios = $this->beneficios->buscar_beneficios_x_id($id_beneficio);
            $beneficios_categoria = $this->categoriaBeneficios->listar_beneficioscategoria($id_beneficio);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'beneficios/vista_detallebeneficios.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_usobeneficios(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $socios = $this->socio->listar_socios();
            $beneficiosuso = $this->beneficios->listar_beneficios();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'beneficios/vista_usobeneficio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function guardar_beneficio() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $this->beneficios->beneficio_nombre = $_POST['idinputbeneficio_nombre'];
            $this->beneficios->beneficio_descripcion = $_POST['idinputbeneficio_descripcion'];
            $this->beneficios->beneficio_idtipobenificios = $_POST['idinput_tipobeneficio'];
            $this->beneficios->beneficio_fecha = $_POST['fecha'];

            if($_POST['id_beneficio'] != 0){
                $this->beneficios->id_beneficio = $_POST['id_beneficio'];
            } else{
                $existe_beneficios = $this->beneficios->buscar_beneficios_x_id($_POST['id_beneficio']);
                if(!empty($existe_beneficios)){
                    throw new Exception("Ya existe el beneficio");
                }
            }

            $id_beneficios = $this->beneficios->guardar_beneficios($this->beneficios);
            if($id_beneficios === 0){
                throw new Exception("Ocurrió un error al registrar el beneficio.");
            }

            $success = true;
            $message = "Se ha Guardado la categoria al beneficio correctamente.";
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

    public function guardar_categoriabeneficio() {
        $code = 0;
        $success = false;
        $message = "";

        try{

            $this->categoriaBeneficios->categoriabeneficio_idcategoria  = $_POST['idcategoria'];
            $this->categoriaBeneficios->categoriabeneficio_idbeneficio = $_POST['idbeneficio'];
            $this->categoriaBeneficios->categoriabeneficio_cant = $_POST['cant'];
            $this->categoriaBeneficios->categoriabeneficio_fecha = $_POST['fecha'];
            if($_POST['idcategoriabeneficio'] != 0){
                $this->categoriaBeneficios->id_categoriabeneficio = $_POST['idcategoriabeneficio'];
            } else{
                $existe_categoriaBeneficios = $this->categoriaBeneficios->existe_beneficioscategoria_con_idcategoria($_POST['idcategoria'], $_POST['idbeneficio']);
                if($existe_categoriaBeneficios){
                    throw new Exception("Ya existe una categoria asociada a este beneficio");
                }
            }

            $id_categoriaBeneficios = $this->categoriaBeneficios->guardar_categoriaBeneficios($this->categoriaBeneficios);
            if($id_categoriaBeneficios === 0){
                throw new Exception("Ocurrió un error al registrar la categoria al beneficio.");
            }

            $success = true;
            $message = "Se ha Guardado la categoria al beneficio correctamente.";
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

    public function eliminar_categoriabeneficio() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $idcategoriabeneficio = $_POST['idcategoriabeneficio'];
            $success = $this->categoriaBeneficios->eliminar_categoriaBeneficios($idcategoriabeneficio);
            if(!$success){
                throw new Exception("Ocurrió un error al eliminar la categoria del beneficio.");
            }

            $message = "Se ha eliminado la categoria del beneficio correctamente.";
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

    public function eliminar_beneficio() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $idbeneficio = $_POST['idbeneficio'];
            $success = $this->beneficios->eliminar_beneficios($idbeneficio);
            if(!$success){
                throw new Exception("Ocurrió un error al eliminar el beneficio.");
            }

            $message = "Se ha eliminado el beneficio correctamente.";
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

    public function listar_categoriaben_select() {
        $result = [];
        try{
            $idbeneficio = $_POST['id'];
            $result = $this->categoriaBeneficios->listar_beneficioscategoria($idbeneficio);
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        echo json_encode($result);
    }

    //Uso Benficicio
    public function guardar_beneficiouso() {
        $code = 0;
        $success = false;
        $message = "";

        try{
//            if($_POST['id_sociobeneficioacumulado'] != 0){
//                $this->beneficiousosocio->id_sociobeneficioacumulado = $_POST['idcategoriabeneficio'];
//            }
//            else{
//                $existe_categoriaBeneficios = $this->categoriaBeneficios->existe_beneficioscategoria_con_idcategoria($_POST['idcategoria'], $_POST['idbeneficio']);
//                if($existe_categoriaBeneficios){
//                    throw new Exception("Ya existe una categoria asociada a este beneficio");
//                }
//            }

            $this->beneficiousosocio->sociobeneficioacumulado_idsocio =$_POST['idsocio'];
            $this->beneficiousosocio->sociobeneficioacumulado_idbeneficio = $_POST['idbeneficio'];
            $this->beneficiousosocio->sociobeneficioacumulado_cant = $_POST['cant'];
            $this->beneficiousosocio->sociobeneficioacumulado_fecha = $_POST['fecha'];
            $idbeneficiouso = $this->beneficiousosocio->registrar_beneficiosUsoSocio($this->beneficiousosocio);
            if($idbeneficiouso === 0){
                throw new Exception("Ocurrió un Error al registrar el beneficioUsoSocio");
            }

            $success = true;
            $message = "Se ha Guardado el beneficiousosocio correctamente.";
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

    public function eliminar_beneficiouso() {
        $code = 0;
        $success = false;
        $message = "";

        try{
            $idbeneficiouso = $_POST['idbeneficiouso'];
            $success = $this->beneficiousosocio->eliminar_beneficiosUsoSocio($idbeneficiouso);
            if(!$success){
                throw new Exception("Ocurrió un error al eliminar el uso del beneficio.");
            }

            $message = "Se ha eliminado correctamente.";
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