<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:01
 */
class Categorias{
    private $pdo;
    private $log;

    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_categorias(){
        try{
            $sql = 'select * from categorias where categoria_estado=1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_categoria_id($id_categoria){
        try{
            $sql = 'select * from categorias where id_categoria=?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_categoria]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_categorias_select(){
        try{
            $sql = 'select * from categorias';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function buscar_categoria_nombre($nombre){
        try{
            $sql = 'select id_categoria from categorias where categoria_nombre = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nombre]);
            $result = $stm->fetch();
            if(isset($result->id_categoria)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function buscar_categoria_nombre_e($nombre,$id){
        try{
            $sql = 'select id_categoria from categorias where categoria_nombre = ? and id_categoria <> ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$nombre,$id]);
            $result = $stm->fetch();
            if(isset($result->id_categoria)){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function guardar_categoria($model){
        try{
            if(isset($model->id_categoria)){
                $sql = 'update categorias set
                        categoria_nombre = ?,
                        categoria_cuota = ?,
                        categoria_inscripcion = ?,
                        categoria_cuota_anual = ?,
                        categoria_horas_auditorio = ?,
                        categoria_estado = ?
                        where id_categoria = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->categoria_nombre,
                    $model->categoria_cuota,
                    $model->categoria_inscripcion,
                    $model->categoria_cuota_anual,
                    $model->categoria_horas_auditorio,
                    $model->categoria_estado,
                    $model->id_categoria
                ]);
            } else {
                $sql = 'insert into categorias (categoria_nombre, categoria_cuota, categoria_inscripcion, categoria_cuota_anual, categoria_horas_auditorio, categoria_estado, categoria_usuario, categoria_datetime) values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->categoria_nombre,
                    $model->categoria_cuota,
                    $model->categoria_inscripcion,
                    $model->categoria_cuota_anual,
                    $model->categoria_horas_auditorio,
                    $model->categoria_estado,
                    $model->categoria_usuario,
                    date('Y-m-d H:i:s')
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }
}
