<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    header('Location: /index.php?sucesso=0');
    exit();
}

// Realiza a validação da URL
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /index.php?sucesso=0');
    exit();
}

// Realiza a validação do título
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /index.php?sucesso=0');
    exit();
}

//Deleta o id do vídeo passado.
$sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
$statement = $pdo->prepare($sql);
$statement->bindValue(':url', $url);
$statement->bindValue(':title', $titulo);
$statement->bindValue(':id', $id, PDO::PARAM_INT);

// Quando o statement é executado, o navegador redireciona o cliente para o seguinte local.
if ($statement->execute() === false) {
    header('location: /index.php?sucesso=0');
} else {
    header('location: /index.php?sucesso=1');
}