<?php

namespace app\common;

use PDO;
use PDOException;

class DataBase
{
    public $conn = null;

    public function __construct()
    {
        try {
            $conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DB']}", $_ENV['DB_USER'], $_ENV['DB_PWD']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch (PDOException $e) {
            $response['status'] = 0;
            $response['msg'] = '数据库错误，请稍后重试!';
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
        }
    }

    public function close()
    {
        $this->conn = null;
    }
}
