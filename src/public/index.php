<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (file_exists("../{$path}.php")) {
    require_once '../../vendor/autoload.php';
    $config = require_once '../../config.php';

    if ($config['is_debug']) {
        $dotenv = Dotenv\Dotenv::createImmutable("../../");
        $dotenv->load();
    }

    header("Content-Type: application/json");
    session_save_path("../../runtime/session");

    require_once "../{$path}.php";
} else {
    http_response_code(404);
}
