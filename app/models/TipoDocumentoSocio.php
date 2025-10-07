<?php

class TipoDocumentoSocio {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function guardar_TipoDocumentoSocio($model): int {
        try{
            if(isset($model->idsociodocumento)){
                $sql = 'update socio_documentos set
                        sociodocumento_tipodocsocio = ?,
                        sociodocumento_idsocio = ?,
                        sociodocumento_nombrearchivo = ?,
                        sociodocumento_rutaarchivo = ?,
                        where idsociodocumento = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->sociodocumento_tipodocsocio,
                    $model->sociodocumento_idsocio,
                    $model->sociodocumento_nombrearchivo,
                    $model->sociodocumento_rutaarchivo,
                    $model->sociodocumento_fecha,
                    $model->idsociodocumento
                ]);
            }
            else {
                $sql = 'INSERT INTO socio_documentos(
                             sociodocumento_tipodocsocio, 
                             sociodocumento_idsocio, 
                             sociodocumento_nombrearchivo, 
                             sociodocumento_rutaarchivo, 
                             sociodocumento_fecha)VALUES(?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->sociodocumento_tipodocsocio,
                    $model->sociodocumento_idsocio,
                    $model->sociodocumento_nombrearchivo,
                    $model->sociodocumento_rutaarchivo,
                    $model->sociodocumento_fecha
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}