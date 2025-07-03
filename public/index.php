<?php
session_start();
require '../vendor/autoload.php';
require '../src/routes.php';


$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/manutix/public'; 

if ($requestUri === $basePath || $requestUri === $basePath . '/') {
    header("Location: $basePath/login");
    exit();
}

$router->run($router->routes);