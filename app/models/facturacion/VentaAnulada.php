<?php

class VentaAnulada
{
    private $pdo;
    private $log;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_detalle_anulados($id) {
        try {
            $sql = 'SELECT * FROM ventas_anulados where id_venta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
}