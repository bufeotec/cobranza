<?php

class Serie {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function actualizarcorrelativo($serie) : bool {
        try{
            // 1. Obtener cantidad de registros de la TABLA VENTA
            $sqlCount = "SELECT COUNT(*) as total FROM ventas WHERE venta_serie = ?";
            $stmCount = $this->pdo->prepare($sqlCount);
            $stmCount->execute([$serie]);
            $row = $stmCount->fetch(PDO::FETCH_OBJ);

            // 2. actualizo la tabla serie
            $cantidad = $row->total ?? 0;
            $sql = 'update serie set correlativo = ? where serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([ $cantidad, $serie ]);
            return true;
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }

    public function listarSerie($tipo_venta): array  {
        try{
            $sql = 'select * from serie where tipocomp = ? and estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo_venta]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_TipoComprobante(): array {
        try{
            $sql = 'select tipocomp, nombrecomp from serie where id_serie <= 3 and estado = 1;';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listarSerie_NC_x_id($tipo_venta, $id): array {
        try{
            $sql = 'select * from serie where tipocomp = ? and id_serie=? and estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$tipo_venta, $id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_correlativos_x_serie($id_serie){
        try{
            $sql = 'select * from serie where id_serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_serie]);
            $return = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $return = [];
        }
        return $return;
    }
}