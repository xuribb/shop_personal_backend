<?php

namespace app\user;

session_destroy();
$response['status'] = 1;
$response['msg'] = '退出成功';

exit(json_encode($response));
