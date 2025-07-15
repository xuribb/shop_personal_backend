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

if (empty($body['captcha']) || strtoupper($_SESSION['captcha']) != strtoupper($body['captcha'])) {
    $response['status'] = 0;
    $response['msg'] = '验证码错误!';
    exit(json_encode($response));
}

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response));
}

$stmt = $db->conn->prepare("SELECT * from user where username = ?");
$status = $stmt->execute([$body['username']]);
$user = $stmt->fetch();
$db->close();
if ($user && password_verify($body['password'], $user['password'])) {
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
