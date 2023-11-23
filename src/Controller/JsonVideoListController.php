<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Obtém uma lista de todos os objetos Video do repositório de vídeos
        $videoList = array_map(function (Video $video): array {
            // Mapeia cada objeto Video para um array associativo contendo informações relevantes
            return [
                'url' => $video->url,
                'title' => $video->title,
                 // Verifica se há um caminho de arquivo associado ao vídeo e o inclui no array, caso contrário, define como null
                'file_path' => $video->getFilePath() === null ? null : '/img/uploads/' . $video->getFilePath(),
            ];
        }, $this->videoRepository->all());

        return new Response(200, [
            'Content-Type' => 'application/json'
        ], 
        // Converte a lista de vídeos para formato JSON e a imprime como resposta
        json_encode($videoList));
    }
}
