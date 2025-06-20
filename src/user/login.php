<?php

namespace app\user;

use app\common\DataBase;

$body = file_get_contents('php://input');
$body = json_decode($body, true);

$response = [];

if (empty($body['username']) || empty($body['password'])) {
    $response['status'] = 0;
    $response['msg'] = '用户名或密码错误!';
    exit(json_encode($response));
}

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response));
}

$stmt = $db->conn->prepare("SELECT * from user where username = ? and password = ?");
$status = $stmt->execute([$body['username'], md5(md5($body['password']).$config['salt'])]);
$user = $stmt->fetch();
$db->close();
if ($user) {
    session_start();
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $response['status'] = 1;
    $response['msg'] = '登录成功！';
    exit(json_encode($response));
} else {
    $response['status'] = 0;
    $response['msg'] = '用户名或密码错误!';
    exit(json_encode($response));
}
