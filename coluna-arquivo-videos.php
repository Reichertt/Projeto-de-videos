<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// Verifica se conectou
echo 'Comando executado com sucesso.';

$pdo->exec('ALTER TABLE videos ADD COLUMN image_path TEXT');