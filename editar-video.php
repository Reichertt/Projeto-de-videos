<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// Realiza a validação do ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: /?sucesso=0');
    exit();
}

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

// Edita o id do vídeo passado.
$sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
$statement = $pdo->prepare($sql);
$statement->bindValue(':url', $url);
$statement->bindValue(':title', $titulo);
$statement->bindValue(':id', $id, PDO::PARAM_INT);

$video = new \Alura\Mvc\Entity\Video($url, $titulo);
$video->setId($id);

// Executa o respectivo comando
$repository = new \Alura\Mvc\Repository\VideoRepository($pdo);
$repository->update($video); 

// Quando o statement é executado, o navegador redireciona o cliente para o seguinte local.
if ($statement->execute() === false) {
    header('location: /?sucesso=0');
} else {
    header('location: /?sucesso=1');
}