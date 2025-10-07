<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 1/10/2025
 * Time: 19:59
 */
class ApiLog
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function registrar($controlador, $accion, $post, $get, $session, $ip, $userAgent, $user = null)
    {
        if(empty($user)){
            $user = null;
        }
        try {
            $sql = "INSERT INTO api_log (controlador, accion, post_data, get_data, session_data, ip, user_agent, id_user)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $controlador,
                $accion,
                json_encode($post, JSON_UNESCAPED_UNICODE),
                json_encode($get, JSON_UNESCAPED_UNICODE),
                json_encode($session, JSON_UNESCAPED_UNICODE),
                $ip,
                $userAgent,
                $user
            ]);
            return true;
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            return false;
        }
    }

    public function listar()
    {
        try {
            $sql = "SELECT * FROM api_log ORDER BY fecha DESC LIMIT 200";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e) {
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $result = [];
        }
        return $result;
    }
}
