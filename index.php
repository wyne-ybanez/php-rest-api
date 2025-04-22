<?php

declare(strict_types=1);

// autoloads classes for use from `/src`
// would normally use composer for autoloading in realworld business setting
spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

// errors & exception handlers
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// ensures http responses are in expected json format
header("Content-type: application/json; charset=UTF-8");

// Simple output to frontend for path tracking - excludes /products/{id}
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!preg_match('#^(/products(/|$)|/product/\d+$)#', $path)) {
    echo json_encode([
        "URL Path" => $path,
    ]);
}

// URL parts explode
$parts = explode("/", $_SERVER["REQUEST_URI"]);

if ($parts[1] != "products") {
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

// Initialize classes
$database = new Database("localhost", "product_db", "root", "");

$gateway = new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
