<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class JsonVideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        // Define o cabeçalho HTTP para indicar que o conteúdo da resposta é JSON
        header('Content-Type: application/json');

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

        // Converte a lista de vídeos para formato JSON e a imprime como resposta
        echo json_encode($videoList);
    }
}
