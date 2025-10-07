<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 19/10/2020
 * Time: 20:01
 */
class Socios{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_socios(): array {
        try {
            $sql = 'SELECT * FROM socio as s
            left join clientes as c on s.socio_id_cliente = c.id_cliente 
            left join sectores as se on s.socio_sector = se.id_sector
            left join rubros as ru on s.socio_rubro = ru.id_rubro
            left join categorias as ca on s.socio_id_categoria = ca.id_categoria
            order by s.id_socio desc';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_socios_activos(): array {
        try {
            $sql = 'SELECT * FROM socio as s
            left join clientes as c on s.socio_id_cliente = c.id_cliente 
            left join sectores as se on s.socio_sector = se.id_sector
            left join rubros as ru on s.socio_rubro = ru.id_rubro
            left join categorias as ca on s.socio_id_categoria = ca.id_categoria where s.socio_estado = 1
            order by s.id_socio desc';

            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function existe_socio_con_idcliente($idcliente): bool {
        try {
            $sql = 'SELECT COUNT(*) FROM socio WHERE socio_id_cliente = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idcliente]);
            $count = $stm->fetchColumn();
            return $count > 0;
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return false;
        }
    }


    public function detalle_afiliacion_socio($idsocio){
        try{
            $sql = 'SELECT se.sector_nombre, r.rubro_nombre, ca.categoria_nombre, ca.categoria_cuota, ca.categoria_inscripcion, s.*, c.* FROM socio as s
            left join sectores as se on s.socio_sector = se.id_sector
            left join rubros as r on s.socio_rubro = r.id_rubro
            left JOIN categorias AS ca ON s.socio_id_categoria = ca.id_categoria     
            left join clientes as c on s.socio_id_cliente = c.id_cliente
            WHERE s.id_socio = ? limit 1;';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idsocio]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_actividad_empresa_socio($idsocio): array {
        try{
            $sql = 'select sa.id_socio_actividad,sa.socio_actividad_id_socio, a.actividad_nombre from socio_actividad as sa
            inner join socio as s on sa.socio_actividad_id_socio = s.id_socio
            inner join actividades as a on sa.socio_actividad_id_actividad = a.id_actividad
            where sa.socio_actividad_id_socio = ?';

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idsocio]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_sectores(): array {
        try{
            $sql = 'select * from sectores';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_rubro_x_sector($id){
        try{
            $sql = 'select * from rubros where id_sector=?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function guardar_socio($modelsocios) : int {
        try{
            if(isset($modelsocios->id_socio)){
                //codigo para actualizar
            }
            else{
                $sql = 'insert into socio(
                    socio_id_cliente, socio_nombre_comercial, socio_departamento, socio_provincia, socio_distrito,
                    socio_sector, socio_rubro, socio_fecha_fundacion, socio_descripcion_actividad, socio_pagina_web,
                    socio_nombre_ejecutivo, socio_cargo_ejecutivo, socio_ornomastico, socio_email_ejecutivo,
                    socio_id_categoria, socio_tipo_pago, socio_creacion, socio_rutalogo)
                    values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

                $sqlstm = $this->pdo->prepare($sql);
                $sqlstm->execute([
                    $modelsocios->socio_id_cliente,
                    $modelsocios->socio_nombre_comercial,
                    $modelsocios->socio_departamento,
                    $modelsocios->socio_provincia,
                    $modelsocios->socio_distrito,
                    $modelsocios->socio_sector,
                    $modelsocios->socio_rubro,
                    $modelsocios->socio_fecha_fundacion,
                    $modelsocios->socio_descripcion_actividad,
                    $modelsocios->socio_pagina_web,
                    $modelsocios->socio_nombre_ejecutivo,
                    $modelsocios->socio_cargo_ejecutivo,
                    $modelsocios->socio_ornomastico,
                    $modelsocios->socio_email_ejecutivo,
                    $modelsocios->socio_id_categoria,
                    $modelsocios->socio_tipo_pago,
                    $modelsocios->socio_creacion,
                    $modelsocios->socio_rutalogo
                ]);
            }

            // Obtener el último ID insertado
            $lastId = $this->pdo->lastInsertId();
            return $lastId;
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 0;
        }
    }

    public function guardar_documentos_expediente(array $documentos, array $datossocio = []) : array {
        $datos = [];
        $ruta_archivoRUC = "";
        $ruta_archivoDNI = "";
        $ruta_archivo_fichainscripcionfirmada = "";
        $ruta_archivo_vigenciapoder = "";
        $ruta_archivo_partidaregistraoempresa = "";
        $ruta_archivo_reportetercerossunat = "";
        $ruta_archivo_comprobantederechoafiliacion = "";

        try{
            if(empty($datossocio)){
               throw new Exception("El Parametro datossocios vino sin valores en el modelo");
            }

            if(!isset($datossocio["empresa_razonsocial"])){
                throw new Exception("No existe el nombre del socio");
            }

            if(!isset($datossocio["id_socio"])){
                throw new Exception("No existe el idsocio del socio");
            }

            $carpetaprincipal = __DIR__ . "/../../media/documentos/pdf/socios/expedientes/";
            if (!file_exists($carpetaprincipal)) {
                mkdir($carpetaprincipal, 0777, true); // crea carpeta si no existe
            }

            //cada socio tendra una carpeta
            $nombresocio = preg_replace('/[^A-Za-z0-9_-]/', '_', $datossocio["empresa_razonsocial"]);
            $carpeta_socio = __DIR__ . "/../../media/documentos/pdf/socios/expedientes/" . $nombresocio ."_id_" .$datossocio["id_socio"] . "/";
            if (!file_exists($carpeta_socio)) {
                mkdir($carpeta_socio, 0777, true); // crea carpeta si no existe
            }

            if (isset($documentos['archivoidinputRUC']) && $documentos['archivoidinputRUC']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinputRUC']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinputRUC']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nombre_archivo_ficha_ruc_socio = "archivo_ficha_ruc_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nombre_archivo_ficha_ruc_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivoRUC = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nombre_archivo_ficha_ruc_socio;
                $datos[] = [
                    "nombre" => $nombre_archivo_ficha_ruc_socio,
                    "ruta" => $ruta_archivoRUC,
                    "id" => 1
                ];
            }

            if (isset($documentos['archivoidinputDNI']) && $documentos['archivoidinputDNI']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinputDNI']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinputDNI']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nuevo_nombre_archivo_dni_socio = "archivo_dni_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nuevo_nombre_archivo_dni_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivoDNI = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nuevo_nombre_archivo_dni_socio;
                $datos[] = [
                    "nombre" => $nuevo_nombre_archivo_dni_socio,
                    "ruta" => $ruta_archivoDNI,
                    "id" => 2
                ];
            }

            if (isset($documentos['archivoidinput_fichainscripcionfirmada']) && $documentos['archivoidinput_fichainscripcionfirmada']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinput_fichainscripcionfirmada']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinput_fichainscripcionfirmada']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nuevo_nombre_archivo_fichainscripcionfirmada_socio = "archivo_fichainscripcionfirmada_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nuevo_nombre_archivo_fichainscripcionfirmada_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivo_fichainscripcionfirmada = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nuevo_nombre_archivo_fichainscripcionfirmada_socio;
                $datos[] = [
                    "nombre" => $nuevo_nombre_archivo_fichainscripcionfirmada_socio,
                    "ruta" => $ruta_archivo_fichainscripcionfirmada,
                    "id" => 3
                ];
            }

            if (isset($documentos['archivoidinput_vigenciapoder']) && $documentos['archivoidinput_vigenciapoder']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinput_vigenciapoder']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinput_vigenciapoder']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nuevo_nombre_archivo_vigenciapoder_socio = "archivo_vigenciapoder_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nuevo_nombre_archivo_vigenciapoder_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivo_vigenciapoder = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nuevo_nombre_archivo_vigenciapoder_socio;
                $datos[] = [
                    "nombre" => $nuevo_nombre_archivo_vigenciapoder_socio,
                    "ruta" => $ruta_archivo_vigenciapoder,
                    "id" => 4
                ];
            }

            if (isset($documentos['archivoidinput_partidaregistraoempresa']) && $documentos['archivoidinput_partidaregistraoempresa']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinput_partidaregistraoempresa']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinput_partidaregistraoempresa']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nuevo_nombre_archivo_partidaregistraoempresa_socio = "archivo_partidaregistraoempresa_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nuevo_nombre_archivo_partidaregistraoempresa_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivo_partidaregistraoempresa = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nuevo_nombre_archivo_partidaregistraoempresa_socio;
                $datos[] = [
                    "nombre" => $nuevo_nombre_archivo_partidaregistraoempresa_socio,
                    "ruta" => $ruta_archivo_partidaregistraoempresa,
                    "id" => 5
                ];
            }

            if (isset($documentos['archivoidinput_reportetercerossunat']) && $documentos['archivoidinput_reportetercerossunat']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinput_reportetercerossunat']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinput_reportetercerossunat']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nuevo_nombre_archivo_reportetercerossunat_socio = "archivo_reportetercerossunat_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nuevo_nombre_archivo_reportetercerossunat_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivo_reportetercerossunat = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nuevo_nombre_archivo_reportetercerossunat_socio;
                $datos[] = [
                    "nombre" => $nuevo_nombre_archivo_reportetercerossunat_socio,
                    "ruta" => $ruta_archivo_reportetercerossunat,
                    "id" => 6
                ];
            }

            if (isset($documentos['archivoidinput_comprobantederechoafiliacion']) && $documentos['archivoidinput_comprobantederechoafiliacion']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivoidinput_comprobantederechoafiliacion']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivoidinput_comprobantederechoafiliacion']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                // Validar que solo sea PDF
                if (strtolower($extension) !== "pdf") {
                    throw new Exception("El archivo debe ser un PDF");
                }

                // Crear nombre único (ejemplo: socio_12345.pdf)
                $nuevo_nombre_archivo_comprobantederechoafiliacion_socio = "archivo_comprobantederechoafiliacion_socio" . time() . "." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpeta_socio . $nuevo_nombre_archivo_comprobantederechoafiliacion_socio)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivo_comprobantederechoafiliacion = "media/documentos/pdf/socios/expedientes/". $nombresocio . "/" . $nuevo_nombre_archivo_comprobantederechoafiliacion_socio;
                $datos[] = [
                    "nombre" => $nuevo_nombre_archivo_comprobantederechoafiliacion_socio,
                    "ruta" => $ruta_archivo_comprobantederechoafiliacion,
                    "id" => 7
                ];
            }

            return [
                "success" => true,
                "message" => "OK",
                "data" => $datos
            ];
        }
        catch (Throwable $e) {
            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function almacenarfotoempresa(array $documentos, array $datossocio = []) : array {
        $datos = [];
        try{
            if(empty($datossocio)){
                throw new Exception("El Parametro datossocios vino sin valores en el modelo");
            }

            if(!isset($datossocio["empresa_razonsocial"])){
                throw new Exception("No existe el nombre del socio");
            }

            $carpetaprincipal = __DIR__ . "/../../media/logo/sociosempresa/";
            if (!file_exists($carpetaprincipal)) {
                mkdir($carpetaprincipal, 0777, true); // crea carpeta si no existe
            }

            $nombresocio = preg_replace('/[^A-Za-z0-9_-]/', '_', $datossocio["empresa_razonsocial"]);
            if (isset($documentos['archivologoempresa']) && $documentos['archivologoempresa']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $documentos['archivologoempresa']['tmp_name']; // archivo temporal
                $nombreOriginal = $documentos['archivologoempresa']['name']; // nombre original
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

                $extension = strtolower($extension);
                $extensiones_permitidas = ["png", "jpg", "jpeg"];

                if (!in_array($extension, $extensiones_permitidas)) {
                    throw new Exception("El Logo no tiene un formato adecuado (png, jpg o jpeg)");
                }


                // Crear nombre único
                $nombre_logo_archivo = "logo_socio_" .$nombresocio. time() ."." . $extension;

                // Mover archivo a la carpeta
                if (!move_uploaded_file($nombreTmp, $carpetaprincipal . $nombre_logo_archivo)) {
                    throw new Exception("No se pudo guardar el archivo");
                }

                // Ruta que guardarás en BD (ruta relativa al proyecto)
                $ruta_archivo_guardado = "media/logo/sociosempresa/". $nombre_logo_archivo;
                $datos[] = [
                    "nombre" => $nombre_logo_archivo,
                    "ruta" => $ruta_archivo_guardado
                ];
            }

            return [
                "success" => true,
                "message" => "OK",
                "data" => $datos
            ];
        }
        catch (Throwable $e) {
            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }
}
