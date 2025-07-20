<?php

namespace app\user;

use app\common\DataBase;
use PDO;

if (empty($_SESSION['id'])) {
    $response['status'] = 0;
    $response['msg'] = '请重新登录后重试!';
    exit(json_encode($response));
}

$body = file_get_contents('php://input');
$body = json_decode($body, true);

if (empty($body['password_old']) || empty($body['password_new'])) {
    $response['status'] = 0;
    $response['msg'] = '密码错误!';
    exit(json_encode($response));
}

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response));
}

$stmt = $db->conn->prepare("SELECT password from user where id = ?");
$status = $stmt->execute([$_SESSION['id']]);
$password = $stmt->fetch(PDO::FETCH_COLUMN);

if ($password && password_verify($body['password_old'], $password)) {
    $stmt = $db->conn->prepare("UPDATE user SET password = ? where id = ?");
    $status = $stmt->execute([password_hash($body['password_new'], PASSWORD_DEFAULT), $_SESSION['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '修改密码成功！';
        exit(json_encode($response));
    }
}
$response['status'] = 0;
$response['msg'] = '修改密码错误!';
exit(json_encode($response));
