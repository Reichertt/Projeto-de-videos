<?php

// Define o modo estrito de tipos para garantir uma tipagem rigorosa.
declare(strict_types=1);

// Verifica se a chave 'PATH_INFO' existe no array $_SERVER ou se é igual a '/'.
if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/') {
    // Se não houver PATH_INFO ou se for igual a '/', inclui o arquivo 'listagem-videos.php'.
    require_once __DIR__ . '/../listagem-videos.php';
} elseif ($_SERVER['PATH_INFO'] === '/novo-video') {
    // Se PATH_INFO for igual a '/novo-video'.
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Se o método da requisição for GET, inclui o arquivo 'formulario.php'.
        require_once __DIR__ . '/../formulario.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Se o método da requisição for POST, inclui o arquivo 'novo-video.php'.
        require_once __DIR__ . '/../novo-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/editar-video') {
    // Se PATH_INFO for igual a '/editar-video'.
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Se o método da requisição for GET, inclui o arquivo 'formulario.php'.
        require_once __DIR__ . '/../formulario.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Se o método da requisição for POST, inclui o arquivo 'editar-video.php'.
        require_once __DIR__ . '/../editar-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/remover-video') {
    // Se PATH_INFO for igual a '/remover-video', inclui o arquivo 'remover-video.php'.
    require_once __DIR__ . '/../remover-video.php';
} else {
    http_response_code(404);
}