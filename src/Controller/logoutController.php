<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

// Classe responsável por deslogar o usuário da sessão
class LogoutController implements Controller
{
    public function processaRequisicao(): void
    {
        // Destroi a sessão
        session_destroy();
        header('Location: /login');
    }
}
