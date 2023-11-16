<?php

// Conexão com o BD
$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$email = $argv[1];
$password = $argv[2];

// password_hash = cria um novo password hash usando um algoritmo forte de hash de via única.
// PASSWORD_ARGON2ID = Usa o algoritmo Argon2 para criar o hash.
$hash = password_hash($password, PASSWORD_ARGON2ID);

$sql = 'INSERT INTO users (email, password) VALUES (?, ?);';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->bindValue(2, $hash); // Corrigido para usar o hash, não a senha.
$statement->execute();
