<?php
//require 'app/models/Active.php';
require 'app/models/facturacion/Clientes.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';

class ClientesController
{
    private $encriptar;
    private $menu;
    private $log;
//    private $active;
    private $nav;
    private $validar;
    private $clientes;

    public function __construct()
    {
        $this->encriptar = new Encriptar();
        //$this->menu = new Menu();
        $this->log = new Log();
//        $this->active = new Active();
        $this->validar = new Validar();

        $this->clientes = new Clientes();

    }

    public function vista_cliente(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);
            $clientes = $this->clientes->listar_clientes();

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'clientes/listar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_crear_clientes(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $tipo_documento = $this->clientes->listar_documentos();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'clientes/vista_crearcliente.php';
            require _VIEW_PATH_ . 'footer.php';

        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }

    public function vista_editar_clientes(){
        try{
            $this->nav = new Navbar();
            $id_rol = $this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_);
            $grupos = $this->nav->listar_grupos($id_rol);

            $tipo_documento = $this->clientes->listar_documentos();
            $id = $_GET['id'] ?? 0;
            if($id == 0){
                throw new Exception('ID Sin Declarar');
            }

            //$_SESSION['id_cliente'] = $id;
            $clientes = $this->clientes->listar_clientes_editar($id);

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'clientes/editar.php';
            require _VIEW_PATH_ . 'footer.php';

        } catch (Throwable $e){
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }


    //FUNCIONES
    public function guardar_cliente(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;

            //Validacion de datos
            if($ok_data){
                $model = new Clientes();

                if(isset($_POST['id_cliente'])){
                    $validacion = $this->clientes->validar_dni_cliente($_POST['cliente_numero'], $_POST['id_cliente']);
                    $model->id_cliente = $_POST['id_cliente'];
                }else{
                    $validacion = $this->clientes->validar_dni($_POST['cliente_numero']);
                    //Código 5: DNI duplicado
                }

                if($validacion){
                    $result = 5;
                    //$message = "Ya existe un cliente con este Documento de Identidad registrado";
                }
                else{
                    $model->cliente_razonsocial = $_POST['cliente_razonsocial'];
                    $model->cliente_nombre = $_POST['cliente_nombre'];
                    $model->id_tipodocumento = $_POST['id_tipodocumento'];
                    $model->cliente_numero = $_POST['cliente_numero'];
                    $model->cliente_correo = $_POST['cliente_correo'];
                    $model->cliente_direccion = $_POST['cliente_direccion'];
                    $model->cliente_telefono = $_POST['cliente_telefono'];

                    $result = $this->clientes->guardar($model);
                }

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }


    public function eliminar_cliente(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_cliente', 'POST',true,$ok_data,11,'numero',0);

            //Validacion de datos
            if($ok_data) {
                $id_cliente = $_POST['id_cliente'];
                $result = $this->clientes->eliminar_cliente($id_cliente);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }


    public function obtener_datos_x_numdocumento(){
        $success = false;
        $data = [];
        $message = 'OK';

        try{
            $numero = $_POST['numero'];
            $data = $this->clientes->listar_cliente_x_numerodoc($numero);
            if(empty($data)){
                $message = 'No Se Encontro UN CLiente';
            }
            $success = true;
        }
        catch (Exception $e){
            $message = $e->getMessage();
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
        }
        finally{
            //Retornamos el json
            echo json_encode(
                array(
                    "result" => array(
                        "success" => $success,
                        "message" => $message,
                        "data" => $data
                    )
                )
            );
        }
    }

    function cambiar_estado_cliente(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_cliente', 'POST',true,$ok_data,11,'texto',0);
            //Validacion de datos
            if($ok_data) {
                $id_cliente = $_POST['id_cliente'];
                $result = $this->clientes->cambiar_estado_cliente($id_cliente);

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

}