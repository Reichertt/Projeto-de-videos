<?php

declare(strict_types=1);

use Alura\Mvc\Controller\{
    Controller,
    DeleteVideoController,
    EditVideoController,
    Error404Controller,
    NewVideoController,
    VideoFormController,
    VideoListController
};
use Alura\Mvc\Repository\VideoRepository;

// Retorna o seguinte valor nesse local
require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);

// Retorna o seguinte valor nesse local
$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$isLoginRoute = $pathInfo === '/login';

// Inicia a sessão
session_start();

if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
    header( 'location: /login');
    return;
}

$key = "$httpMethod|$pathInfo";

// Verifica se a rota é existente, caso não seja direciona para o erro 404
if (array_key_exists($key, $routes)) {

    $controllerClass = $routes["$httpMethod|$pathInfo"];
    $controller = new $controllerClass($videoRepository);
} else {
    $controller = new Error404Controller();
}

/** @var \Alura\Mvc\Controller\Controller $controller */
$controller->processaRequisicao();