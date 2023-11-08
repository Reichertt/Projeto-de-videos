<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];

//Deleta o id do vídeo passado.
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue( 1, $id);

// Quando o statement é executado, o navegador redireciona o cliente para o seguinte local.
if ($statement->execute() === false) {
    header('location: /index.php?sucesso=0');
} else {
    header('location: /index.php?sucesso=1');
}