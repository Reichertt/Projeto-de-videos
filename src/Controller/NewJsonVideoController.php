<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewJsonVideoController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $request = $request->getBody()->getContents();
        $videoData = json_decode($request, true);

        // Cria um novo objeto Video com os dados fornecidos na requisição
        $video = new Video($videoData['url'], $videoData['title']);

        // Adiciona o objeto Video ao repositório de vídeos ($this->videoRepository é uma instância de alguma classe que gerencia vídeos)
        $this->videoRepository->add($video);

        // Define o código de resposta HTTP como 201 Created, indicando que a operação foi bem-sucedida e um novo recurso foi criado
        return new Response(201);
    }
}
