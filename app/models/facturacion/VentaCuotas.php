<?php

class VentaCuotas {
    private $pdo;
    private $log;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_detalle_cuotas($id): array {
        try {
            $sql = 'SELECT * FROM ventas_cuotas where id_ventas = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_detalle_cuota($model): int {
        try{
            $sql = 'insert into ventas_cuotas (id_ventas,id_tipo_pago,venta_cuota_numero,venta_cuota_importe, venta_cuota_fecha,venta_cuota_datetime) values (?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_ventas,
                $model->id_tipo_pago,
                $model->venta_cuota_numero,
                $model->venta_cuota_importe,
                $model->venta_cuota_fecha,
                $model->venta_cuota_datetime
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }
}