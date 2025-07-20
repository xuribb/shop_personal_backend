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

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response));
}

if ($body['type'] === 'query') {
    $stmt = $db->conn->prepare("SELECT * from base_config where id = 1");
    $status = $stmt->execute();
    $config = $stmt->fetch(PDO::FETCH_ASSOC);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '获取基本配置信息成功！';
        $response['data'] = $config;
        exit(json_encode($response));
    }
} elseif ($body['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE base_config SET site_name=?,site_logo=?,beian=?,com_name=?,com_loc=?,kefu_tel=?,kefu_qq=? where id = 1");
    $status = $stmt->execute([$body['site_name'], $body['site_logo'], $body['beian'], $body['com_name'], $body['com_loc'], $body['kefu_tel'], $body['kefu_qq']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '修改基本配置信息成功！';
        exit(json_encode($response));
    }
}

$response['status'] = 0;
$response['msg'] = '保存基本配置信息错误!';
exit(json_encode($response));
