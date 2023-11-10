<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];

//Deleta o id do vídeo passado.
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue( 1, $id);

// Executa o respectivo comando
$repository = new \Alura\Mvc\Repository\VideoRepository($pdo);

// Quando o statement é executado, o navegador redireciona o cliente para o seguinte local.
if ($repository->remove($id) === false) {
    header('location: /?sucesso=0');
} else {
    header('location: /?sucesso=1');
}