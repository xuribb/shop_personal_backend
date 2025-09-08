<?php

namespace app\user;

use app\common\DataBase;

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

if ($_POST['type'] === 'save') {
    if($_POST['isDefault'] == 1){
        $db->conn->exec("UPDATE location SET isDefault = 0");
    }
    $stmt = $db->conn->prepare("INSERT INTO location(uid, username, phone, address1, address2, isDefault) value(?,?,?,?,?,?)");
    $status = $stmt->execute([$_SESSION['id'], $_POST['username'], $_POST['phone'], json_encode($_POST['address1']), $_POST['address2'], $_POST['isDefault']]);
    $db->close();
    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '保存地址成功!';
        exit(json_encode($response));
    } else {
        $response['status'] = 0;
        $response['msg'] = '操作失败，请稍后重试!';
        exit(json_encode($response));
    }
} else if ($_POST['type'] === 'delete') {
    $stmt = $db->conn->prepare("UPDATE location set status = 0 where id = ?");
    $status = $stmt->execute([$_POST['id']]);
    $db->close();
    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '删除地址成功!';
        exit(json_encode($response));
    } else {
        $response['status'] = 0;
        $response['msg'] = '操作失败，请稍后重试!';
        exit(json_encode($response));
    }
} else if ($_POST['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE location set username=?,phone=?,address1=?,address2=?,isDefault=? where id = ?");
    $status = $stmt->execute([$_POST['username'], $_POST['phone'], json_encode($_POST['address1']), $_POST['address2'], $_POST['isDefault'], $_POST['id']]);
    $db->close();
    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '修改地址成功!';
        exit(json_encode($response));
    } else {
        $response['status'] = 0;
        $response['msg'] = '操作失败，请稍后重试!';
        exit(json_encode($response));
    }
} else if ($_POST['type'] === 'query') {
    $stmt = $db->conn->prepare("SELECT * from location where uid = ? and status = 1");
    $status = $stmt->execute([$_SESSION['id']]);
    $locations = $stmt->fetchAll();
    $db->close();
    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '获取地址信息成功!';
        $response['data'] = $locations;
        exit(json_encode($response));
    } else {
        $response['status'] = 0;
        $response['msg'] = '请重新登录后重试!';
        exit(json_encode($response));
    }
} else {
    $db->close();
    $response['status'] = 0;
    $response['msg'] = '请求方式错误!';
    exit(json_encode($response));
}
