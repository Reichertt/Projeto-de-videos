<?php

namespace Alura\Mvc\Controller;

// Classe responsável pela validação do login
class LoginController implements Controller
{
    // Propriedade para armazenar a instância do PDO (conexão com o banco de dados)
    private \PDO $pdo;

    // Método construtor que cria a instância do PDO e a associa à propriedade $pdo
    public function __construct()
    {
        // Caminho do banco de dados SQLite
        $dbPath = __DIR__ . '/../../banco.sqlite';
        
        // Criação da instância do PDO com o caminho do banco de dados
        $this->pdo = new \PDO("sqlite:$dbPath");
    }

    // Método responsável por processar a requisição relacionada ao login
    public function processaRequisicao(): void
    {
        // Obtém e valida o email e a senha da requisição POST
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Consulta SQL para selecionar os dados do usuário com o email fornecido
        $sql = 'SELECT * FROM users WHERE email = ?';
        
        // Preparação e execução da consulta SQL
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();

        // Obtém os dados do usuário associados ao email fornecido
        $userData = $statement->fetch(\PDO::FETCH_ASSOC);

        // Verifica se a senha fornecida coincide com a senha armazenada no banco de dados
        $correctPassword = password_verify($password, $userData['password'] ?? '');

        // Esta função verifica se o hash fornecido implementa o algoritmo e as opções fornecidas. Caso contrário, presume-se que o hash precisa ser refeito
        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
            $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
            $statement->bindValue(2, $userData['id']);
            $statement->execute();
        }

        // Redireciona o usuário com base no sucesso ou falha da validação da senha
        if ($correctPassword) {

            // Se o usuário conseguir acessar, o login foi bem sucedido
            $_SESSION['logado'] = true;
            header('Location: /'); // Redireciona para a página inicial em caso de sucesso
        } else {
            header('Location: /login?sucess=0'); // Redireciona para a página de login com parâmetro de falha
        }
    }
}
