<?php

class TipoDocumento {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function mostrar_tipodocumentos(): array  {
        try{
            $sql = 'SELECT * FROM tipo_documentos where tipodocumento_estado <> 0 order by id_tipodocumento desc';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
}