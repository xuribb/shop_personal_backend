<?php

namespace app\user;

use app\common\DataBase;

session_start();
if (empty($_SESSION['id'])) {
    $response['status'] = 0;
    $response['msg'] = '请重新登录后重试!';
    exit(json_encode($response));
}

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response));
}

$stmt = $db->conn->prepare("SELECT * from user where id = ?");
$status = $stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();
$db->close();
if ($user) {
    $response['status'] = 1;
    $response['msg'] = '获取用户信息成功!';
    $response['data'] = $user;
    exit(json_encode($response));
} else {
    $response['status'] = 0;
    $response['msg'] = '请重新登录后重试!';
    exit(json_encode($response));
}
