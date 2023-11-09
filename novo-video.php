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

// Insere no BD a seguinte URL e título
$sql = 'INSERT INTO videos (url, title) VALUES (?, ?)';

$statement = $pdo->prepare($sql);

// Envia os seguintes POSTS para o BD
$statement->bindValue(1, $url);
$statement->bindValue(2, $titulo);

// Quando o statement é executado, o navegador redireciona o cliente para o seguinte local.
if ($statement->execute() === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}
