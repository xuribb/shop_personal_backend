<?php

namespace app\user;

use app\common\DataBase;

$response = [];
if (empty($_POST['username']) || empty($_POST['password'])) {
    $response['status'] = 0;
    $response['msg'] = '用户名或密码错误!';
    exit(json_encode($response));
}

if (empty($_POST['captcha']) || strtoupper($_SESSION['captcha']) != strtoupper($_POST['captcha'])) {
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
$status = $stmt->execute([$_POST['username']]);
$user = $stmt->fetch();
$db->close();
if ($user && password_verify($_POST['password'], $user['password'])) {
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
