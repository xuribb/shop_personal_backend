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
    $stmt = $db->conn->prepare("INSERT INTO shop_list(category_id,shop_name,shop_desc,shop_price,shop_img,inventory,sales) VALUES(?,?,?,?,?,?,?)");
    $status = $stmt->execute([$body['category_id'], $body['shop_name'], $body['shop_desc'], $body['shop_price'], $body['shop_img'], $body['inventory'], $body['sales']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '添加商品成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '添加商品失败，请稍后重试';
    }
} else if ($body['type'] === 'query') {
    $query_cd = "";
    if (!empty($body['id'])) {
        $query_cd .= "id = {$body['id']} AND ";
    }
    if (!empty($body['category_id'])) {
        $query_cd .= "category_id = '{$body['category_id']}' AND ";
    }
    if (!empty($body['shop_name'])) {
        $query_cd .= "shop_name LIKE '%{$body['shop_name']}%' AND ";
    }
    $query_cd .= "status=1";

    $body['page_size'] = $body['page_size'] ? $body['page_size'] : 10;
    $limit = ($body['page_num'] - 1) * $body['page_size'] . ',' . $body['page_size'];

    $stmt = $db->conn->prepare("SELECT *,COUNT(id) OVER() AS total FROM shop_list WHERE {$query_cd} LIMIT {$limit}");
    $status = $stmt->execute();
    $shop_categorys = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '获取商品列表成功!';
        $response['data'] = $shop_categorys;
    } else {
        $response['status'] = 0;
        $response['msg'] = '获取商品列表失败，请稍后重试';
    }
} else if ($body['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE shop_list set category_id=?,shop_name=?,shop_desc=?,shop_price=?,shop_img=?,inventory=?,sales=? WHERE id=?");
    $status = $stmt->execute([$body['category_id'], $body['shop_name'], $body['shop_desc'], $body['shop_price'], $body['shop_img'], $body['inventory'], $body['sales'], $body['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '更新商品信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '更新商品信息失败，请稍后重试';
    }
} else if ($body['type'] === 'delete') {
    $stmt = $db->conn->prepare("UPDATE shop_list set `status`=0 WHERE id=?");
    $status = $stmt->execute([$body['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '删除商品信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '删除商品信息失败，请稍后重试';
    }
}

exit(json_encode($response));
