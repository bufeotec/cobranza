<?php

class VentaDetalle {
    private $pdo;
    private $log;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function guardar_detalle_venta($model): int {
        try{
            $sql = 'insert into ventas_detalle (
                            id_venta, 
                            id_servicio, 
                            venta_detalle_descripcion, 
                            venta_detalle_cantidad,
                            venta_detalle_total_igv, 
                            venta_detalle_porcentaje_igv, 
                            venta_detalle_precio_unitario,
                            venta_detalle_valor_total) 
                            values (?,?,?,?,?,?,?,?)';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_venta,
                $model->id_servicio,
                $model->venta_detalle_descripcion,
                $model->venta_detalle_cantidad,
                $model->venta_detalle_total_igv,
                $model->venta_detalle_porcentaje_igv,
                $model->venta_detalle_precio_unitario,
                $model->venta_detalle_valor_total
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function listar_detalle_ventas($id): array {
        try {
            $sql = 'select vd.id_venta_detalle, vd.venta_detalle_porcentaje_igv, vd.venta_detalle_total_igv, vd.venta_detalle_descripcion,
                vd.venta_detalle_precio_unitario,vd.venta_detalle_valor_total, vd.venta_detalle_cantidad, s.servicio_precio_socio, s.id_servicio,s.servicio_nombre, 
                ta.*, m.*, v.* from ventas_detalle as vd
                left join ventas as v on vd.id_venta = v.id_venta
                left join servicios as s on vd.id_servicio = s.id_servicio
                left join tipo_afectacion as ta on s.servicio_tipoafectacion = ta.id_tipo_afectacion
                left join medida as m on s.servicio_idmedida = m.id_medida
                where vd.id_venta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
}