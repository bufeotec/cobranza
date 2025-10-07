<?php

class TipoBeneficios {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_TipoBeneficio(): array {
        try{
            $sql = 'select * from tipobenificios where tipobenificios_estado = 1;';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

}