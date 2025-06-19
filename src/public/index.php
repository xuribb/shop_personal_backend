<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (file_exists("../{$path}.php")) {
    require_once '../../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable("../../");
    $dotenv->load();

    require_once "../{$path}.php";
} else {
    http_response_code(404);
}
