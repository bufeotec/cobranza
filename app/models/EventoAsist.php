<?php

class EventoAsist {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function mostrar_listaeventosasist($idevento): array  {
        try{
            $sql = 'SELECT s.id_socio, s.socio_nombre_comercial,
                IFNULL(ea.id_eventoasist, 0) AS id_eventoasist,
                CASE 
                    WHEN ea.id_eventoasist IS NULL THEN 0     -- no existe → no asistió
                    WHEN ea.eventoasist_estado = 1 THEN 1     -- existe y estado = 1 → asistió
                    ELSE 0                                    -- existe pero estado = 0 → no asistió
                END AS asistio
            FROM socio s
            LEFT JOIN eventos_asist ea ON s.id_socio = ea.eventoasist_idsocio
               AND ea.eventoasist_idevento = ?';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idevento]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function buscar_listaeventos_x_id($idevento) {
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

    public function registrar_eventosasit($model) : int {
        try{
            if(isset($model->id_eventoasist) && !empty($model->id_eventoasist)){
                $sql = 'update eventos_asist set
                        eventoasist_idsocio = ?,
                        eventoasist_idevento = ?, 
                        eventoasist_fecha = ?, 
                        eventoasist_hora = ?
                        where id_eventoasist = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->eventoasist_idsocio,
                    $model->eventoasist_idevento,
                    $model->eventoasist_fecha,
                    $model->eventoasist_hora,
                    $model->id_eventoasist
                ]);
                return (int)$model->id_eventoasist; // Devuelves el mismo ID
            }
            else {
                $sql = 'insert into eventos_asist(
                            eventoasist_idsocio, 
                            eventoasist_idevento, 
                            eventoasist_fecha, 
                            eventoasist_hora)values(?,?,?,?);';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->eventoasist_idsocio,
                    $model->eventoasist_idevento,
                    $model->eventoasist_fecha,
                    $model->eventoasist_hora
                ]);
                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function cambiarestado_eventosasit($ideventoasist, $fecha, $hora) : int {
        try {
            // 1. Obtener el estado actual
            $sql = 'SELECT eventoasist_estado FROM eventos_asist WHERE id_eventoasist = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$ideventoasist]);
            $estado_actual = $stm->fetchColumn();

            if ($estado_actual === false) {
                return 0; // No existe el registro
            }

            // 2. Calcular el nuevo estado (0->1 o 1->0)
            $nuevo_estado = ($estado_actual == 1) ? 0 : 1;

            // 3. Actualizar
            $sql = 'UPDATE eventos_asist SET 
                         eventoasist_estado = ?, 
                         eventoasist_fecha = ?, 
                        eventoasist_hora = ? 
                     WHERE id_eventoasist = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nuevo_estado, $fecha, $hora, $ideventoasist]);
            return (int)$ideventoasist;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }


    public function eliminar_eventosasit($id_eventoasist): bool {
        try {
            $sql = 'DELETE FROM eventos_asist WHERE id_eventoasist = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_eventoasist]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
}