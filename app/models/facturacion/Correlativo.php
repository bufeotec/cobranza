<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 2/05/2019
 * Time: 13:18
 */

class Correlativo{
    private $log;
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar(){
        try{
            $sql = 'select * from correlativos limit 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = $stm->fetch();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = [];
        }
        return $return;
    }

    public function guardar_edicion($model){
        try{
            $sql = 'update correlativos set correlativo_b = ?, correlativo_f = ?, correlativo_in = ?, correlativo_out = ?, correlativo_nc = ?, correlativo_nd = ?, correlativo_venta = ? where id_correlativo = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->correlativo_b,
                $model->correlativo_f,
                $model->correlativo_in,
                $model->correlativo_out,
                $model->correlativo_nc,
                $model->correlativo_nd,
                $model->correlativo_venta,
                $model->id_correlativo
            ]);
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }

    public function updatecorrelativeOut(){
        try{
            $sql = 'update correlativos set correlativo_out = correlativo_out + 1 where id_correlativo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }

    public function updatecorrelativeIn(){
        try{
            $sql = 'update correlativos set correlativo_in = correlativo_in + 1 where id_correlativo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }

    public function updatecorrelativeb(){
        try{
            $sql = 'update correlative set correlative_b = correlative_b + 1 where id_correlative = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }
    public function updatecorrelativeventa(){
        try{
            $sql = 'update correlativos set correlativo_venta = correlativo_venta + 1 where id_correlativo = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }

    public function updatecorrelativef(){
        try{
            $sql = 'update correlative set correlative_f = correlative_f+ 1 where id_correlative = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }

    public function updatecorrelativenc(){
        try{
            $sql = 'update correlative set correlative_nc = correlative_nc+ 1 where id_correlative = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }

    public function updatecorrelativend(){
        try{
            $sql = 'update correlative set correlative_nd = correlative_nd+ 1 where id_correlative = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $return = 1;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = 2;
        }
        return $return;
    }
}