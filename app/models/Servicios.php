<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:01
 */
class Servicios{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    //Listamos todos los menus creados en el sistema
    public function listar_servicios_todos(): array {
        try{
            $sql = 'select * from servicios s inner join servicios_categoria sc on s.id_servicios_categoria = sc.id_servicio_categoria';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_servicios(): array {
        try{
            $sql = 'select * from servicios s inner join servicios_categoria sc on s.id_servicios_categoria = sc.id_servicio_categoria where s.servicio_estado=1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_servicios_categoria(): array {
        try{
            $sql = 'select * from servicios_categoria where servicio_categoria_estado=1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function buscar_servicio_nombre($nombre){
        try{
            $sql = 'select id_servicio from servicios where servicio_nombre = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nombre]);
            $result = $stm->fetch();
            if(isset($result->id_servicio)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function buscar_servicio_nombre_e($nombre,$id){
        try{
            $sql = 'select id_servicio from servicios where servicio_nombre = ? and id_servicio <> ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nombre,$id]);
            $result = $stm->fetch();
            if(isset($result->id_servicio)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function buscar_servicio_x_nombre_y_codigo($busqueda): array {
        try {
            $sql = "SELECT  id_servicio, servicio_nombre, servicio_descripcion,
            servicio_precio_normal, servicio_precio_socio FROM servicios
            WHERE id_servicio = :busqueda
            OR servicio_nombre LIKE CONCAT('%', :busqueda, '%')
            OR servicio_descripcion LIKE CONCAT('%', :busqueda, '%')";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['busqueda' => $busqueda]);
            $result = $stmt->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
        return $result;
    }

    public function listar_servicio_id($id){
        try{
            $sql = 'select * from servicios where id_servicio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_serie($id){
        try{
            $sql = 'select * from serie where id_serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function guardar_servicio($model): int {
        try{
            if(isset($model->id_servicio)){
                $sql = 'update servicios set
                        servicio_nombre = ?,
                        servicio_descripcion = ?,
                        id_servicios_categoria = ?,
                        servicio_precio_normal = ?,
                        servicio_precio_socio = ?,
                        servicio_estado = ?,
                        servicio_tipoafectacion = ?
                        where id_servicio = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->servicio_nombre,
                    $model->servicio_descripcion,
                    $model->id_servicios_categoria,
                    $model->servicio_precio_normal,
                    $model->servicio_precio_socio,
                    $model->servicio_estado,
                    $model->id_servicio_tipo_afectacion,
                    $model->id_servicio
                ]);
            }
            else {
                $sql = 'insert into servicios (servicio_nombre,servicio_descripcion,id_servicios_categoria, servicio_precio_normal, servicio_precio_socio, servicio_estado, servicio_usuario, servicio_datetime, servicio_tipoafectacion, servicio_idmedida) values (?,?,?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->servicio_nombre,
                    $model->servicio_descripcion,
                    $model->id_servicios_categoria,
                    $model->servicio_precio_normal,
                    $model->servicio_precio_socio,
                    $model->servicio_estado,
                    $model->servicio_usuario,
                    date('Y-m-d H:i:s'),
                    $model->id_servicio_tipo_afectacion,
                    $model->servicio_idmedida
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}
