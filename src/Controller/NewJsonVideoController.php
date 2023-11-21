<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class NewJsonVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        // Obtém o conteúdo da requisição HTTP POST do corpo da requisição
        $request = file_get_contents('php://input');

        // Decodifica o conteúdo JSON da requisição em um array associativo
        $videoData = json_decode($request, true);

        // Cria um novo objeto Video com os dados fornecidos na requisição
        $video = new Video($videoData['url'], $videoData['title']);

        // Adiciona o objeto Video ao repositório de vídeos (presumivelmente, $this->videoRepository é uma instância de alguma classe que gerencia vídeos)
        $this->videoRepository->add($video);

        // Define o código de resposta HTTP como 201 Created, indicando que a operação foi bem-sucedida e um novo recurso foi criado
        http_response_code(201);
    }
}
