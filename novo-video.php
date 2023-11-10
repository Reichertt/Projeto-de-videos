<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// Realiza a validação da URL
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}

// Realiza a validação do título
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /?sucesso=0');
    exit();
}

// Executa o respectivo comando
$repository = new \Alura\Mvc\Repository\VideoRepository($pdo);

// Quando o statement é executado, o navegador redireciona o cliente para o seguinte local.
if ($repository->add(new \Alura\Mvc\Entity\Video($url, $titulo)) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}