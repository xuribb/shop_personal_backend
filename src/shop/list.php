<?php

namespace app\shop;

use app\common\DataBase;
use PDO;

$response = [];
$db = new DataBase();

if ($_POST['type'] === 'save') {
    if (!empty($_FILES['shop_img'])) {
        $uploadDir = '../public/upload/';

        $ext = pathinfo($_FILES['shop_img']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('shop_', true) . '.' . $ext;
        $destination = $uploadDir . $filename;
        move_uploaded_file($_FILES['shop_img']['tmp_name'], $destination);
        $_POST['shop_img'] = '/upload/' . $filename;
    }

    $stmt = $db->conn->prepare("INSERT INTO shop_list(category_id,shop_name,shop_desc,shop_price,shop_img,inventory,sales) VALUES(?,?,?,?,?,?,?)");
    $status = $stmt->execute([$_POST['category_id'], $_POST['shop_name'], $_POST['shop_desc'], $_POST['shop_price'], $_POST['shop_img'], $_POST['inventory'], $_POST['sales']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '添加商品成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '添加商品失败，请稍后重试';
    }
} else if ($_POST['type'] === 'query') {
    $query_cd = "";
    if (!empty($_POST['id'])) {
        $query_cd .= "id = {$_POST['id']} AND ";
    }
    if (!empty($_POST['ids'])) {
        $query_cd .= "id in ({$_POST['ids']}) AND ";
    }
    if (!empty($_POST['category_id'])) {
        $query_cd .= "category_id = '{$_POST['category_id']}' AND ";
    }
    if (!empty($_POST['shop_name'])) {
        $query_cd .= "shop_name LIKE '%{$_POST['shop_name']}%' AND ";
    }
    $query_cd .= "status=1";

    $_POST['page_size'] = empty($_POST['page_size']) ? 10 : $_POST['page_size'];
    $_POST['page_num'] = empty($_POST['page_num']) ? 1 : $_POST['page_num'];
    $limit = ($_POST['page_num'] - 1) * $_POST['page_size'] . ',' . $_POST['page_size'];

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
} else if ($_POST['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE shop_list set category_id=?,shop_name=?,shop_desc=?,shop_price=?,shop_img=?,inventory=?,sales=? WHERE id=?");
    $status = $stmt->execute([$_POST['category_id'], $_POST['shop_name'], $_POST['shop_desc'], $_POST['shop_price'], $_POST['shop_img'], $_POST['inventory'], $_POST['sales'], $_POST['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '更新商品信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '更新商品信息失败，请稍后重试';
    }
} else if ($_POST['type'] === 'delete') {
    $stmt = $db->conn->prepare("UPDATE shop_list set `status`=0 WHERE id=?");
    $status = $stmt->execute([$_POST['id']]);
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
