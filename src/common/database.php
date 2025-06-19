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
            $this->conn = null;
        }
    }
    public function close()
    {
        $this->conn = null;
    }
}
