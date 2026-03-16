<?php
use App\Router;
use App\Database\Connection;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true);
$router = new Router();
try {
    $db = Connection::getConnection();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "   Archivo: " . $e->getFile() . " línea " . $e->getLine() . "\n";
}

require_once __DIR__ . '/../routes/routes.php'; 

$router->dispatch($uri, $method, $body, $db);