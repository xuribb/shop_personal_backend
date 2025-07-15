<?php

namespace app\user;

use app\common\DataBase;
use PDO;

$body = file_get_contents("php://input");
$body = json_decode($body, true);

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

$query_cd = "";
if (!empty($body['id'])) {
    $query_cd .= "id = {$body['id']} AND ";
}
if (!empty($body['username']) && $body['username'] != 'admin') {
    $query_cd .= "username = '{$body['username']}' AND ";
} else {
    $query_cd .= "username != 'admin' AND ";
}
if (!empty($body['phone'])) {
    $query_cd .= "phone = '{$body['phone']}' AND ";
}
if (!empty($body['email'])) {
    $query_cd .= "email = '{$body['email']}' AND ";
}
$query_cd .= "1";

$body['page_size'] = $body['page_size'] ? $body['page_size'] : 10;
$limit = ($body['page_num'] - 1) * $body['page_size'] . ',' . $body['page_size'];

$stmt = $db->conn->prepare("SELECT id,username,gender,phone,email,create_time,count(id) over() as total from user where {$query_cd} limit {$limit}");
$status = $stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
$db->close();

$response['status'] = 1;
$response['msg'] = '获取用户列表成功!';
$response['data'] = $user;
exit(json_encode($response));
