<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

use App\Controller\ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$controller = new ProductController();

$routes = [
    ['POST',   '#^/products$#',                  fn ()           => $controller->create()],
    ['GET',    '#^/products/([a-f0-9-]+)$#',     fn ($m)         => $controller->get($m[1])],
    ['PATCH',  '#^/products/([a-f0-9-]+)$#',     fn ($m)         => $controller->update($m[1])],
    ['DELETE', '#^/products/([a-f0-9-]+)$#',     fn ($m)         => $controller->delete($m[1])],
    ['GET',    '#^/products$#',                  fn ()           => $controller->list()],
];

$matched = false;

foreach ($routes as [$routeMethod, $pattern, $handler]) {
    if ($method === $routeMethod && preg_match($pattern, $uri, $matches)) {
        try {
            $handler($matches);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
