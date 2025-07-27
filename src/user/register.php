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

$stmt = $db->conn->prepare("SELECT id from user where username = ?");
$status = $stmt->execute([$_POST['username']]);
$user = $stmt->fetch();
if ($user) {
    $response['status'] = 0;
    $response['msg'] = '用户名已存在!';
    exit(json_encode($response));
}

$stmt = $db->conn->prepare("INSERT INTO user (username, password, avatar) VALUES (?, ?, '/images/avatar.png')");
$status = $stmt->execute([$_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);
$id = $db->conn->lastInsertId();
$db->close();
if ($status) {
    $_SESSION['id'] = $id;
    $_SESSION['username'] = $_POST['username'];
    $response['status'] = 1;
    $response['msg'] = '注册成功！';
} else {
    $response['status'] = 0;
    $response['msg'] = '注册失败，请稍后重试！';
}
exit(json_encode($response));
