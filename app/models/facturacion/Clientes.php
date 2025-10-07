<?php

class Clientes
{
    private $pdo;
    private $log;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }



    public function guardar($model): int {
        try {
            if (isset($model->id_cliente) && !empty($model->id_cliente)) {
                // UPDATE
                $sql = 'UPDATE clientes SET
                cliente_tipopersona = ?,
                id_tipodocumento = ?,
                cliente_numero = ?,
                cliente_razonsocial = ?,
                cliente_nombre = ?,
                cliente_correo = ?,
                cliente_celular1 = ?,
                cliente_celular2 = ?,
                cliente_telefono1 = ?,
                cliente_telefono2 = ?,
                cliente_direccion = ?
                WHERE id_cliente = ?';

                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->cliente_tipopersona,
                    $model->id_tipodocumento,
                    $model->cliente_numero,
                    $model->cliente_razonsocial,
                    $model->cliente_nombre,
                    $model->cliente_correo,
                    $model->cliente_celular1,
                    $model->cliente_celular2,
                    $model->cliente_telefono1,
                    $model->cliente_telefono2,
                    $model->cliente_direccion,
                    $model->id_cliente
                ]);

                return (int)$model->id_cliente; // Devuelves el mismo ID
            }
            else {
                // INSERT
                $sql = 'INSERT INTO clientes (
                    cliente_tipopersona, id_tipodocumento, cliente_numero, cliente_razonsocial, 
                    cliente_nombre, cliente_correo, cliente_celular1, cliente_celular2,
                    cliente_telefono1, cliente_telefono2, cliente_direccion, cliente_fecha
                ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';

                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->cliente_tipopersona,
                    $model->id_tipodocumento,
                    $model->cliente_numero,
                    $model->cliente_razonsocial,
                    $model->cliente_nombre,
                    $model->cliente_correo,
                    $model->cliente_celular1,
                    $model->cliente_celular2,
                    $model->cliente_telefono1,
                    $model->cliente_telefono2,
                    $model->cliente_direccion,
                    $model->cliente_fecha
                ]);

                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }



    public function listar_documentos(): array
    {
        try{
            $sql = 'select * from tipo_documentos where tipodocumento_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_clientes(): array {
        try{
            $sql = 'select * from clientes where cliente_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_clientes_editar($id){
        try{
            $sql = 'select * from clientes where id_cliente = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function eliminar_cliente($id_cliente): int {
        try{
            $sql = 'delete from clientes where id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_cliente_x_numerodoc($doc_numero){
        try{
            $sql = 'select * from clientes where cliente_numero = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$doc_numero]);
            return $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return [];
        }
    }

    //Validar dni
    public function validar_dni($cliente_numero){
        try{
            $sql = 'select * from clientes where cliente_numero = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$cliente_numero]);
            $resultado = $stm->fetch();
            (isset($resultado->id_cliente))?$result=true:$result=false;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    //validar dni y cliente
    public function validar_dni_cliente($cliente_numero, $id_cliente){
        try{
            $sql = 'select * from clientes where cliente_numero = ? and id_cliente <> ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$cliente_numero,$id_cliente]);
            $resultado = $stm->fetch();
            (isset($resultado->id_cliente))?$result=true:$result=false;
        }
        catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    //VALIDACION
    public function validar($id_cliente){
        try{
            $sql = "select * from ventas v inner join clientes c on v.id_cliente = c.id_cliente where v.id_cliente = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            $result = $stm->fetchAll();
        }
        catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    function cambiar_estado_cliente($id_cliente){
        try {
            $sql = "update clientes set
                cliente_estado = 0
                where id_cliente = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_cliente
            ]);
            $result = 1;
        }
        catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

}
