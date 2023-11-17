<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

// Classe responsável pela manipulação dos dados do BD
class VideoRepository
{
    // Função construtora
    public function __construct(private \PDO $pdo)
    {
    }

    // Função para adicionar um vídeo
    public function add(Video $video): bool
    {
        // Insere no BD a seguinte URL e título
        $sql = 'INSERT INTO videos (url, title, image_path) VALUES (?, ?, ?)';

        $statement = $this->pdo->prepare($sql);

        // Envia os seguintes POSTS para o BD
        $statement->bindValue(1, $video->url);
        $statement->bindValue(2, $video->title);
        $statement->bindValue(3, $video->getFilePath());

        $result = $statement->execute();
        $id = $this->pdo->lastInsertId();
        $video->setId(intval($id));

        return $result;
    }

    // Função para remover um vídeo
    public function remove(int $id): bool
    {
        //Deleta o id do vídeo passado.
        $sql = 'DELETE FROM videos WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }

    // Função para realizar edição no vídeo
    public function update(Video $video): bool
    {
        $updateImageSql = '';
        if ($video->getFilePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }

        // Edita o id do vídeo passado.
        $sql = "UPDATE videos SET
                  url = :url,
                  title = :title
                $updateImageSql
              WHERE id = :id;";
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, PDO::PARAM_INT);

        if ($video->getFilePath() !== null) {
            $statement->bindValue(':image_path', $video->getFilePath());
        }

        return $statement->execute();
    }

    /**
     *  Retorna todos os vídeos do banco
     * @return Video[]
     */
    public function all(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...),
            $videoList
        );
    }

    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, \PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);

        if ($videoData['image_path'] !== null) {
            $video->setFilePath($videoData['image_path']);
        }

        return $video;
    }
}
