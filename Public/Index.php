<?php
require_once __DIR__ . '/../src/Config/Bootstrap.php';
use App\Router;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($method, $uri);