<?php
namespace app\article;

use app\common\DataBase;
use PDO;

$response = [];
$db = new DataBase();

if ($_POST['type'] === 'save') {
    $_POST['pid'] = $_POST['pid'] == 'null' ? null : $_POST['pid'];
    $stmt = $db->conn->prepare("INSERT INTO article(pid, name) VALUES(?, ?)");
    $status = $stmt->execute([$_POST['pid'], $_POST['name']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '添加文章分类成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '添加文章分类失败，请稍后重试';
    }
} else if ($_POST['type'] === 'query') {
    $stmt = $db->conn->prepare("SELECT * FROM article");
    $status = $stmt->execute();
    $article = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '获取文章分类列表成功!';
        $response['data'] = $article;
    } else {
        $response['status'] = 0;
        $response['msg'] = '获取文章分类列表失败，请稍后重试';
    }
} else if ($_POST['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE article set name=? WHERE id=?");
    $status = $stmt->execute([$_POST['name'], $_POST['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '更新文章信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '更新文章信息失败，请稍后重试';
    }
} else if ($_POST['type'] === 'delete') {
    $stmt = $db->conn->prepare("DELETE FROM article WHERE id=?");
    $status = $stmt->execute([$_POST['id']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '删除文章信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '删除文章信息失败，请稍后重试';
    }
}

exit(json_encode($response, JSON_UNESCAPED_UNICODE));
