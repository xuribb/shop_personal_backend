<?php

namespace app\shop;

use app\common\DataBase;
use PDO;

$body = file_get_contents("php://input");
$body = json_decode($body, true);
$response = [];

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

if ($body['type'] === 'save') {
    $stmt = $db->conn->prepare("INSERT INTO shop_category(category_name, order_id) VALUES(?, ?)");
    $status = $stmt->execute([$body['category_name'], $body['order_id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '添加商品分类成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '添加商品分类失败，请稍后重试';
    }
} else if ($body['type'] === 'query') {
    $stmt = $db->conn->prepare("SELECT * FROM shop_category WHERE `status`=1 ORDER BY order_id");
    $status = $stmt->execute();
    $shop_categorys = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '获取商品分类列表成功!';
        $response['data'] = $shop_categorys;
    } else {
        $response['status'] = 0;
        $response['msg'] = '获取商品分类列表失败，请稍后重试';
    }
} else if ($body['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE shop_category set category_name=?,order_id=? WHERE id=?");
    $status = $stmt->execute([$body['category_name'], $body['order_id'], $body['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '更新商品分类信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '更新商品分类信息失败，请稍后重试';
    }
} else if ($body['type'] === 'delete') {
    $stmt = $db->conn->prepare("UPDATE shop_category set `status`=0 WHERE id=?");
    $status = $stmt->execute([$body['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '删除商品分类信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '删除商品分类信息失败，请稍后重试';
    }
}

exit(json_encode($response));
