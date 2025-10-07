<?php

class Actividad{
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_actividades(){
        try{
            $sql = 'select * from actividades';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function guardar_actividad_empresa_model($modelactividad) : int {
        try{
            if(isset($modelactividad->id_actividad)){
                //codigo para actualizar
            }
            else{
                $sql = 'insert into actividades(actividad_nombre, actividad_creacion) values(?,?)';
                $sqlstm = $this->pdo->prepare($sql);
                $sqlstm->execute([
                    $modelactividad->actividad_nombre,
                    $modelactividad->actividad_creacion
                ]);
            }

            return 1;
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function guardar_socio_actividad($modelsocioactividad) : int {
        try{
            if(isset($modelsocioactividad->id_socio_actividad)){
                //codigo para actualizar
            }
            else{
                $sql = 'insert into socio_actividad(socio_actividad_id_socio, socio_actividad_id_actividad, socio_actividad_creacion)values(?,?,?)';
                $sqlstm = $this->pdo->prepare($sql);
                $sqlstm->execute([
                    $modelsocioactividad->socio_actividad_id_socio,
                    $modelsocioactividad->socio_actividad_id_actividad,
                    $modelsocioactividad->socio_actividad_creacion
                ]);
            }
            return 1;
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}
