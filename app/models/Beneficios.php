<?php

class Beneficios {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_beneficios(): array  {
        try{
            $sql = 'SELECT * FROM beneficios as b
            left join tipobenificios as tb on b.beneficio_idtipobenificios = tb.id_tipobeneficio 
            where b.beneficio_estado = 1';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function buscar_beneficios_x_id($idbeneficio) {
        try{
            $sql = 'SELECT * FROM beneficios as b
            left join tipobenificios as tb on b.beneficio_idtipobenificios = tb.id_tipobeneficio 
            where b.beneficio_estado = 1 and b.id_beneficio = ?';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idbeneficio]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_beneficios($model) : int {
        try{
            if(isset($model->id_beneficio) && !empty($model->id_beneficio)){
                $sql = 'update beneficios set
                        beneficio_nombre = ?,
                        beneficio_descripcion = ?,
                        beneficio_idtipobenificios = ?
                        where id_beneficio = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->beneficio_nombre,
                    $model->beneficio_descripcion,
                    $model->beneficio_idtipobenificios,
                    $model->id_beneficio
                ]);
                return (int)$model->id_beneficio; // Devuelves el mismo ID
            }
            else {
                $sql = 'insert into beneficios(
                            beneficio_nombre, 
                            beneficio_descripcion, 
                            beneficio_idtipobenificios, 
                            beneficio_fecha)values(?,?,?,?);';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->beneficio_nombre,
                    $model->beneficio_descripcion,
                    $model->beneficio_idtipobenificios,
                    $model->beneficio_fecha
                ]);
                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function eliminar_beneficios($idbeneficio): bool {
        try {
            $sql = 'DELETE FROM beneficios WHERE id_beneficio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idbeneficio]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }


}