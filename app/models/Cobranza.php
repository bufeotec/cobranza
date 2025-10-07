<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 2/09/2025
 * Time: 12:30
 */
class Cobranza
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_socios_categoria($id_categoria){
        try{
            $sql = 'select * from socio s inner join clientes c on c.id_cliente = s.socio_id_cliente where s.socio_id_categoria = ? and s.socio_estado = 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_categoria]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    function mes_en_espanol_mayus($num){
        static $meses = [
            1  => 'ENERO',
            2  => 'FEBRERO',
            3  => 'MARZO',
            4  => 'ABRIL',
            5  => 'MAYO',
            6  => 'JUNIO',
            7  => 'JULIO',
            8  => 'AGOSTO',
            9  => 'SEPTIEMBRE',
            10 => 'OCTUBRE',
            11 => 'NOVIEMBRE',
            12 => 'DICIEMBRE',
        ];
        $n = (int)$num; // acepta '01', '1', 1, etc.
        return $meses[$n] ?? ''; // devuelve '' si está fuera de 1..12
    }

    public function listar_socios_facturados($query = ""){
        try{
            $sql = "select * from cobranza c inner join socio s on c.id_socio = s.id_socio inner join categorias c2 on c.id_categoria = c2.id_categoria inner join clientes cl on cl.id_cliente = s.socio_id_cliente ". $query;
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_socios_facturacion($socio_id_categoria){
        try{
            $sql = "select * from socio s inner join clientes c on c.id_cliente = s.socio_id_cliente where s.socio_id_categoria = ? and s.socio_estado = 1 and s.socio_estado_facturacion = 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$socio_id_categoria]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_socios_facturacion_filtrado($socio_id_categoria, $anho, $mes){
        try{
            $sql = "select s.*,c.* from socio s inner join clientes c on c.id_cliente = s.socio_id_cliente
                     LEFT JOIN cobranza co
                       ON co.id_socio = s.id_socio
                      AND co.cobranza_anho = ?
                      AND co.cobranza_mes  = ?
                    where s.socio_id_categoria = ? and s.socio_estado = 1 and s.socio_estado_facturacion = 1 and co.id_cobranza IS NULL;";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$anho, $mes, $socio_id_categoria]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //SCRIPT para levantar facturas automaticas de Setiembre 2025
    /*public function listar_socios_facturados(){
        try{
            $sql = "select * from ventas v inner join clientes c on v.id_cliente = c.id_cliente inner join socio s on s.socio_id_cliente = c.id_cliente where v.venta_tipo = '01'";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }*/

    public function insertar_cobranza($model){
        try{
            $sql = "insert into cobranza (id_socio, id_categoria, cobranza_anho, cobranza_mes, cobranza_fecha_vencimiento, cobranza_monto, cobranza_monto_cobrado, id_venta, cobranza_estado) values (?,?,?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_socio,
                $model->id_categoria,
                $model->cobranza_anho,
                $model->cobranza_mes,
                $model->cobranza_fecha_vencimiento,
                $model->cobranza_monto,
                $model->cobranza_monto_cobrado,
                $model->id_venta,
                $model->cobranza_estado
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function insertar_comprobante_cobranza($model){
        try{
            $sql = "insert into comprobantes_cobranza (id_cobranza, comprobante_descripcion, comprobante_ruta, comprobante_monto, comprobante_fecha, comprobante_estado) values (?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->id_cobranza,
                $model->comprobante_descripcion,
                $model->comprobante_ruta,
                $model->comprobante_monto,
                $model->comprobante_fecha,
                $model->comprobante_estado
            ]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_comprobantes_cobranza($id_cobranza){
        try{
            $sql = "select * from comprobantes_cobranza where comprobante_estado = 1 and id_cobranza = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cobranza]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_cobranza_id($id_cobranza){
        try{
            $sql = "select * from cobranza where id_cobranza = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cobranza]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function sumar_monto_comprobantes($id_cobranza){
        try{
            $sql = "select sum(comprobante_monto) as monto from comprobantes_cobranza where comprobante_estado = 1 and id_cobranza = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cobranza]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function actualizar_estado_cobranza($id_cobranza, $cobranza_estado){
        try{
            $sql = "update cobranza set cobranza_estado = ? where id_cobranza = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$cobranza_estado, $id_cobranza]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function eliminar_comprobantes_cobranza($id_comprobante_cob){
        try{
            $sql = "delete from comprobantes_cobranza where id_comprobante_cob = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_comprobante_cob]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }
}