<?php

namespace app\store;

use app\common\DataBase;
use PDO;

$response = [];
$db = new DataBase();

if ($_POST['type'] === 'save') {
    $stmt = $db->conn->prepare("INSERT INTO delivery(way) VALUES(?)");
    $status = $stmt->execute([$_POST['way']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '添加配送方式成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '添加配送方式失败，请稍后重试';
    }
} else if ($_POST['type'] === 'query') {
    $stmt = $db->conn->query("SELECT * FROM delivery ORDER BY `order`");
    $delivery = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db->close();

    $response['status'] = 1;
    $response['msg'] = '获取配送方式成功!';
    $response['data'] = $delivery;
} else if ($_POST['type'] === 'delete') {
    $stmt = $db->conn->prepare("DELETE FROM delivery WHERE id=?");
    $status = $stmt->execute([$_POST['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '删除配送方式成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '删除配送方式失败，请稍后重试';
    }
}

exit(json_encode($response, JSON_UNESCAPED_UNICODE));
