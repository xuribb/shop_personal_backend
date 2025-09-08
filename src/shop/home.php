<?php

namespace app\shop;

use app\common\DataBase;
use PDO;

$db = new DataBase();

$sql = "SELECT a.*,b.category_name FROM (SELECT *, ROW_NUMBER() OVER(PARTITION BY category_id) AS row_num FROM shop_list where status = 1) AS a JOIN shop_category b ON a.category_id = b.id WHERE a.row_num <=4";

$stmt = $db->conn->query($sql);
$shop_categorys = $stmt->fetchAll(PDO::FETCH_ASSOC);
$db->close();

$data = [];
foreach ($shop_categorys as $val) {
    if (!array_key_exists($val['category_name'], $data)) {
        $data[$val['category_name']] = [];
    }
    array_push($data[$val['category_name']], $val);
}

$response['status'] = 1;
$response['msg'] = '获取商品列表成功!';
$response['data'] = $data;

exit(json_encode($response));
