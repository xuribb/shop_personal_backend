<?php

namespace app\user;

use app\common\DataBase;
use PDO;

if (empty($_SESSION['id'])) {
    $response['status'] = 0;
    $response['msg'] = '请重新登录后重试!';
    exit(json_encode($response));
}

if (!empty($_FILES)) {
    $uploadDir = '../public/upload/';

    $ext = pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $destination = $uploadDir . $filename;
    move_uploaded_file($_FILES['site_logo']['tmp_name'], $destination);
    $_POST['site_logo'] = '/upload/' . $filename;
}

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response));
}

if ($_POST['type'] === 'query') {
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
} elseif ($_POST['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE base_config SET site_name=?,site_logo=?,beian=?,com_name=?,com_loc=?,kefu_tel=?,kefu_qq=? where id = 1");
    $status = $stmt->execute([$_POST['site_name'], $_POST['site_logo'], $_POST['beian'], $_POST['com_name'], $_POST['com_loc'], $_POST['kefu_tel'], $_POST['kefu_qq']]);
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
