<?php

namespace Alura\Mvc\Entity;

use InvalidArgumentException;

// Classe responsável pela validção da URL e definição de entidades
class Video
{
    // Define a propriedade id
    public readonly int $id;

    // Define a propriedade URL
    public readonly string $url;

    // Define que a imagem pode ter uma string ou ser nula
    private ?string $filePath = null;

    public function __construct(string $url, public readonly string $title,)
    {
        $this->setUrl($url);
    }

    // Faz a verificação se o campo de URL é realmente uma URL
    private function setUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException();
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
}
