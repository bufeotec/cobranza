<?php
/**
 * Created by PhpStorm.
 * User: CesarJose39
 * Date: 25/11/2018
 * Time: 11:13
 */

class Admin{
    private $log;
    private $pdo;

    public function __construct()
    {
        $this->log = new Log();
        $this->pdo = Database::getConnection();
    }

    //Contar Usuarios Registrados
    public function count_users(){
        try{
            $sql = 'select count(id_usuario) total from usuarios';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $r = $stm->fetch();
            $return = $r->total;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), 'Admin|count_user');
            $return = 2;
        }
        return $return;
    }
    //FUNCION PARA VALIDAR ULTIMA FECHA
    public function listar_ultima_fecha($fecha_hoy){
        try{
            $sql = 'select * from caja where DATE(caja_apertura_fecha) = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy]);
            $result = $stm->fetchAll();
            if(count($result) == 1){
                $result = true;
            } else {
                $result = false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }

    //Registrar la apertura de caja
    public function guardar_apertura_caja($model){
        $fecha_actual = date('Y-m-d H:i:s');
        try{
            if(isset($model->id_caja)){
                $sql = 'update caja set
                        caja_fecha = ?,
                        caja_apertura = ?,
                        id_usuario_apertura = ?,
                        caja_apertura_fecha = ?,
                        caja_cierre = ?,
                        id_usuario_cierre = ?,
                        caja_cierre_fecha = ?
                        where id_caja = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->caja_fecha,
                    $model->caja_apertura,
                    $model->id_usuario_apertura,
                    $model->caja_apertura_fecha,
                    $model->caja_cierre,
                    $model->id_usuario_cierre,
                    $fecha_actual,
                    $model->id_caja
                ]);
            } else {
                $sql = 'insert into caja (caja_fecha, caja_apertura,id_caja_numero, id_usuario_apertura, caja_apertura_fecha, caja_cierre, id_usuario_cierre, caja_cierre_fecha) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $fecha_actual,
                    $model->caja_apertura,
                    $model->id_caja_numero,
                    $model->id_usuario_apertura,
                    $fecha_actual,
                    $model->caja_cierre,
                    $model->id_usuario_cierre,
                    $fecha_actual
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    //FUNCION PARA VALIDAR ULTIMA FECHA
    public function mostrar_valor_apertura($fecha_hoy){
        try{
            $sql = 'select caja_apertura from caja where date(caja_apertura_fecha) = ? limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy]);
            $ret = $stm->fetch();
            $return = $ret->caja_apertura;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 0;
        }
        return $return;
    }
}