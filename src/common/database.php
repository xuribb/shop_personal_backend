<?php
namespace app\common;

use PDO;
use PDOException;
try {
    $conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DB']}", $_ENV['DB_USER'], $_ENV['DB_PWD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "连接成功"; 
}
catch(PDOException $e) {
    echo "连接失败: " . $e->getMessage();
}

$conn = null;
