<?php

class Evento {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function mostrar_listaeventos(): array  {
        try{
            $sql = 'SELECT * FROM eventos where evento_estado <> 0 order by id_evento desc';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function buscar_listaeventos_x_id($idevento) {
        try{
            $sql = 'SELECT * FROM eventos where id_evento = ?';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idbeneficio]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function registrar_eventos($model) : int {
        try{
            if(isset($model->id_evento) && !empty($model->id_evento)){
                $sql = 'update eventos set
                        evento_nombre = ?,
                        evento_fecha = ?,
                        evento_estado = ?
                        where id_evento = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->evento_nombre,
                    $model->evento_fecha,
                    $model->evento_estado,
                    $model->id_evento
                ]);
                return (int)$model->id_evento; // Devuelves el mismo ID
            }
            else {
                $sql = 'insert into eventos(
                            evento_nombre, 
                            evento_fecha,
                            evento_estado)values(?,?,?);';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->evento_nombre,
                    $model->evento_fecha,
                    $model->evento_estado
                ]);
                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function cambiarestado_eventos($id_evento, $estado): bool {
        try {
            $sql = 'UPDATE eventos SET evento_estado = ? WHERE id_evento = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$estado, $id_evento]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }

    public function eliminar_eventos($id_evento): bool {
        try {
            $sql = 'DELETE FROM eventos WHERE id_evento = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_evento]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
}