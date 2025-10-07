<?php

class Atencion {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function mostrar_listaatencion(): array  {
        try{
            $sql = 'SELECT * FROM atencion where atencion_estado = 1 order by id_atencion desc';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function buscar_listaatencion_x_id($idbeneficio) {
        try{
            $sql = 'SELECT * FROM atencion as b
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

    public function registrar_atencion($model) : int {
        try{
            if(isset($model->id_atencion) && !empty($model->id_atencion)){
                $sql = 'update atencion set
                        atencion_dni = ?,
                        atencion_nombre = ?, 
                        atencion_area = ?, 
                        atencion_motivo = ?, 
                        atencion_observacion = ?
                        where id_atencion = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->atencion_dni,
                    $model->atencion_nombre,
                    $model->atencion_area,
                    $model->atencion_motivo,
                    $model->atencion_observacion,
                    $model->id_atencion
                ]);
                return (int)$model->id_atencion; // Devuelves el mismo ID
            }
            else {
                $sql = 'insert into atencion(
                            atencion_dni, 
                            atencion_nombre, 
                            atencion_area, 
                            atencion_motivo, 
                            atencion_observacion, 
                            atencion_fecha)values(?,?,?,?,?,?);';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->atencion_dni,
                    $model->atencion_nombre,
                    $model->atencion_area,
                    $model->atencion_motivo,
                    $model->atencion_observacion,
                    $model->atencion_fecha
                ]);
                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function eliminar_atencion($idatencion): bool {
        try {
            $sql = 'DELETE FROM atencion WHERE id_atencion = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idatencion]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
}