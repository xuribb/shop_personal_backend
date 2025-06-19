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

$stmt = $db->conn->prepare("SELECT id from user where username = ?");
$status = $stmt->execute([$body['username']]);
$user = $stmt->fetch();
if ($user) {
    $response['status'] = 0;
    $response['msg'] = '用户名已存在!';
    exit(json_encode($response));
}

$stmt = $db->conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
$status = $stmt->execute([$body['username'], md5(md5($body['password']) . $config['salt'])]);
$db->close();
if ($status) {
    $response['status'] = 1;
    $response['msg'] = '注册成功！';
} else {
    $response['status'] = 0;
    $response['msg'] = '注册失败，请稍后重试！';
}
exit(json_encode($response));
