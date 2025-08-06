<?php
namespace app\article;

use app\common\DataBase;
use PDO;

$response = [];
$db = new DataBase();

if ($_POST['type'] === 'query') {
    $stmt = $db->conn->prepare("SELECT update_time,content FROM article_detail where aid = ?");
    $stmt->execute([$_POST['aid']]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($content === false) {
        $stmt = $db->conn->prepare("INSERT INTO article_detail(aid) VALUES(?)");
        $stmt->execute([$_POST['aid']]);
    }
    $db->close();

    $response['status'] = 1;
    $response['msg'] = '获取文章内容成功!';
    $response['data'] = $content;
} else if ($_POST['type'] === 'update') {
    $stmt = $db->conn->prepare("UPDATE article_detail set content=? WHERE aid = ?");
    $status = $stmt->execute([$_POST['content'], $_POST['aid']]);
    $db->close();

    if ($status) {
        $response['status'] = 1;
        $response['msg'] = '更新文章信息成功!';
    } else {
        $response['status'] = 0;
        $response['msg'] = '更新文章信息失败，请稍后重试';
    }
}

exit(json_encode($response, JSON_UNESCAPED_UNICODE));
