<?php

namespace app\user;

use app\common\DataBase;
use PDO;

if (empty($_SESSION['id'])) {
    $response['status'] = 0;
    $response['msg'] = '请重新登录后重试!';
    exit(json_encode($response, JSON_UNESCAPED_UNICODE));
}

$db = new DataBase();
if ($db->conn === null) {
    $response['status'] = 0;
    $response['msg'] = '网络错误，请稍后重试!';
    exit(json_encode($response, JSON_UNESCAPED_UNICODE));
}

if ($_POST['type'] === 'save') {
    $stmt = $db->conn->prepare("SELECT id from shopcart where user_id = ? and shop_id = ?");
    $stmt->execute([$_SESSION['id'], $_POST['shop_id']]);
    $id = $stmt->fetch(PDO::FETCH_COLUMN);
    if($id){
        $db->close();
        $response['status'] = 1;
        $response['msg'] = '已添加购物车';
        exit(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    $stmt = $db->conn->prepare("INSERT INTO shopcart(user_id, shop_id) value(?,?)");
    $status = $stmt->execute([$_SESSION['id'], $_POST['shop_id']]);
    $db->close();
    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '加入购物车成功!';
        exit(json_encode($response, JSON_UNESCAPED_UNICODE));
    } else {
        $response['status'] = 0;
        $response['msg'] = '加入购物车失败，请稍后重试!';
        exit(json_encode($response, JSON_UNESCAPED_UNICODE));
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
