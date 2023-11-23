<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

// Classe responsável pela validação do login
class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    // Propriedade para armazenar a instância do PDO (conexão com o banco de dados)
    private \PDO $pdo;

    public function __construct()
    {
        // Caminho do banco de dados SQLite
        $dbPath = __DIR__ . '/../../banco.sqlite';

        // Criação da instância do PDO com o caminho do banco de dados
        $this->pdo = new \PDO("sqlite:$dbPath");
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Consulta SQL para selecionar os dados do usuário com o email fornecido
        $sql = 'SELECT * FROM users WHERE email = ?';
        // Preparação e execução da consulta SQL
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();

        $userData = $statement->fetch(\PDO::FETCH_ASSOC);
        // Verifica se a senha fornecida coincide com a senha armazenada no banco de dados
        $correctPassword = password_verify($password, $userData['password'] ?? '');

        // Redireciona o usuário com base no sucesso ou falha da validação da senha
        if (!$correctPassword) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        // Esta função verifica se o hash fornecido implementa o algoritmo e as opções fornecidas. Caso contrário, presume-se que o hash precisa ser refeito
        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
            $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
            $statement->bindValue(2, $userData['id']);
            $statement->execute();
        }

        // Se o usuário conseguir acessar, o login foi bem sucedido
        $_SESSION['logado'] = true;
        return new Response(302, ['Location' => '/']);
    }
}
