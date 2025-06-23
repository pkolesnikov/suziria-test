<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$uri = rtrim($uri, '/');

if ($uri === '/products' && $method === 'POST') {
    $controller = new ProductController();
    $controller->create();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
