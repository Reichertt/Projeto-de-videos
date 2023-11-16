<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// Verifica se conectou
echo 'A tabela users foi criada com sucesso';

$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password TEXT);');