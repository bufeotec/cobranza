<?php

class BeneficioUsoSocio {
    private $pdo;
    private $log;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function existe_beneficiosUsoSocio_con_id($idcategoria, $idbeneficio): bool {
        try {
            $sql = 'SELECT COUNT(*) FROM categoria_beneficio 
                WHERE categoriabeneficio_idcategoria = ? and categoriabeneficio_idbeneficio = ?';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idcategoria,  $idbeneficio]);
            $count = $stm->fetchColumn();
            return $count > 0;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }

    public function registrar_beneficiosUsoSocio($model) : int {
        try{
            if(isset($model->id_sociobeneficioacumulado) && !empty($model->id_sociobeneficioacumulado)){
                $sql = 'update socio_beneficioacumulado set
                        sociobeneficioacumulado_idsocio = ?,
                        sociobeneficioacumulado_idbeneficio = ?,
                        sociobeneficioacumulado_cant = ?
                        where id_sociobeneficioacumulado = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->sociobeneficioacumulado_idsocio,
                    $model->sociobeneficioacumulado_idbeneficio,
                    $model->sociobeneficioacumulado_cant,
                    $model->id_sociobeneficioacumulado
                ]);
                return (int)$model->id_sociobeneficioacumulado; // Devuelves el mismo ID

            }
            else {
                $sql = 'insert into socio_beneficioacumulado(
                            sociobeneficioacumulado_idsocio, 
                            sociobeneficioacumulado_idbeneficio,
                            sociobeneficioacumulado_cant, 
                            sociobeneficioacumulado_fecha)values(?,?,?,?);';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->sociobeneficioacumulado_idsocio,
                    $model->sociobeneficioacumulado_idbeneficio,
                    $model->sociobeneficioacumulado_cant,
                    $model->sociobeneficioacumulado_fecha
                ]);
                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function eliminar_beneficiosUsoSocio($idbeneficiouso): bool {
        try {
            $sql = 'DELETE FROM socio_beneficioacumulado WHERE id_sociobeneficioacumulado = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idbeneficiouso]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }

    public function listar_beneficiosUsoSocio() : array  {
        try{
            $sql = 'SELECT * FROM socio_beneficioacumulado as sba
            left join socio as s on sba.sociobeneficioacumulado_idsocio = s.id_socio
            left join beneficios as b on sba.sociobeneficioacumulado_idbeneficio = b.id_beneficio';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }


    public function listar_beneficiouso_mesactual($idSocio, $fecha): array {
        try {
            $sql = "SELECT 
                    s.id_socio,
                    cl.cliente_razonsocial,
                    s.socio_nombre_comercial,
                    b.beneficio_idtipobenificios AS idtipobenificio,
                    tb.tipobenificios_nombre,
                    c.id_categoria,
                    c.categoria_nombre,
                    b.id_beneficio,
                    b.beneficio_nombre,
                    cb.categoriabeneficio_cant AS cantidad_maxima_mes,
                    COALESCE(SUM(sba.sociobeneficioacumulado_cant), 0) AS cantidad_usada_mes,
                    (cb.categoriabeneficio_cant - COALESCE(SUM(sba.sociobeneficioacumulado_cant), 0)) AS cantidad_restante,
                    DATE_FORMAT(?, '%Y-%m') AS periodo
                FROM socio s
                LEFT JOIN clientes cl ON s.socio_id_cliente = cl.id_cliente
                LEFT JOIN categorias c ON s.socio_id_categoria = c.id_categoria
                LEFT JOIN socio_beneficioacumulado sba 
                       ON sba.sociobeneficioacumulado_idsocio = s.id_socio
                      AND sba.sociobeneficioacumulado_estado = 1
                      AND YEAR(sba.sociobeneficioacumulado_fecha) = YEAR(?)
                      AND MONTH(sba.sociobeneficioacumulado_fecha) = MONTH(?)
                LEFT JOIN beneficios b ON sba.sociobeneficioacumulado_idbeneficio = b.id_beneficio
                LEFT JOIN tipobenificios tb ON b.beneficio_idtipobenificios = tb.id_tipobeneficio
                LEFT JOIN categoria_beneficio cb 
                       ON cb.categoriabeneficio_idcategoria = c.id_categoria
                      AND cb.categoriabeneficio_idbeneficio = b.id_beneficio
                WHERE s.id_socio = ?
                GROUP BY s.id_socio, cl.cliente_razonsocial, s.socio_nombre_comercial,
                         c.id_categoria, c.categoria_nombre,
                         b.id_beneficio, b.beneficio_nombre, cb.categoriabeneficio_cant
                ORDER BY b.id_beneficio";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha, $fecha, $fecha, $idSocio]);
            $result = $stm->fetchAll();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_uso_por_mes($idSocio): array {
        try {
            $sql = "SELECT 
                    DATE_FORMAT(sba.sociobeneficioacumulado_fecha, '%Y-%m') AS periodo,
                    SUM(sba.sociobeneficioacumulado_cant) AS cantidad_usada_mes
                FROM socio_beneficioacumulado sba
                WHERE sba.sociobeneficioacumulado_idsocio = ?
                  AND sba.sociobeneficioacumulado_estado = 1
                GROUP BY DATE_FORMAT(sba.sociobeneficioacumulado_fecha, '%Y-%m')
                ORDER BY periodo DESC";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idSocio]);
            $result = $stm->fetchAll();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_detalle_uso($idSocio): array {
        try {
            $sql = "SELECT sba.id_sociobeneficioacumulado,  b.beneficio_nombre, 
            sba.sociobeneficioacumulado_cant, tb.tipobenificios_nombre, sba.sociobeneficioacumulado_fecha, 
            DATE_FORMAT(sba.sociobeneficioacumulado_fecha, '%Y-%m') AS periodo
            FROM socio_beneficioacumulado sba
            LEFT JOIN beneficios b ON sba.sociobeneficioacumulado_idbeneficio = b.id_beneficio
            LEFT JOIN tipobenificios as tb on b.beneficio_idtipobenificios = tb.id_tipobeneficio
            WHERE sba.sociobeneficioacumulado_idsocio = ?
            AND sba.sociobeneficioacumulado_estado = 1
            ORDER BY periodo DESC, sba.sociobeneficioacumulado_fecha DESC";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idSocio]);
            $result = $stm->fetchAll();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
}