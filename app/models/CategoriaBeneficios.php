<?php

class CategoriaBeneficios {
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function existe_beneficioscategoria_con_idcategoria($idcategoria, $idbeneficio): bool {
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

    public function listar_beneficioscategoria($idbeneficio): array  {
        try{
            $sql = 'SELECT * FROM categoria_beneficio as cb
            left join categorias as c on cb.categoriabeneficio_idcategoria = c.id_categoria
            left join beneficios as b on cb.categoriabeneficio_idbeneficio = b.id_beneficio
            left join tipobenificios as tb on b.beneficio_idtipobenificios = tb.id_tipobeneficio
            where cb.categoriabeneficio_estado = 1 and cb.categoriabeneficio_idbeneficio = ?';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idbeneficio]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function guardar_categoriaBeneficios($model) : int {
        try{
            if(isset($model->id_categoriabeneficio) && !empty($model->id_categoriabeneficio)){
                $sql = 'update categoria_beneficio set
                        categoriabeneficio_idcategoria = ?,
                        categoriabeneficio_idbeneficio = ?,
                        categoriabeneficio_cant = ?
                        where id_categoriabeneficio = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->categoriabeneficio_idcategoria,
                    $model->categoriabeneficio_idbeneficio,
                    $model->categoriabeneficio_cant,
                    $model->id_categoriabeneficio
                ]);
                return (int)$model->id_categoriabeneficio; // Devuelves el mismo ID

            }
            else {
                $sql = 'insert into categoria_beneficio(
                            categoriabeneficio_idcategoria, 
                            categoriabeneficio_idbeneficio, 
                            categoriabeneficio_cant, 
                            categoriabeneficio_fecha)values(?,?,?,?);';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->categoriabeneficio_idcategoria,
                    $model->categoriabeneficio_idbeneficio,
                    $model->categoriabeneficio_cant,
                    $model->categoriabeneficio_fecha
                ]);
                return (int)$this->pdo->lastInsertId(); // Devuelves el nuevo ID
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function eliminar_categoriaBeneficios($idcategoriabeneficio): bool {
        try {
            $sql = 'DELETE FROM categoria_beneficio WHERE id_categoriabeneficio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idcategoriabeneficio]);

            return $stm->rowCount() > 0; // true si eliminó algo
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }
}