<?php

namespace Alura\Mvc\Controller;

// Classe responsável por deslogar o usuário da sessão
class LogoutController implements Controller
{
    public function processaRequisicao(): void
    {
        // Destroi a sessão
        session_destroy();
        header('location: /login');
    }
}