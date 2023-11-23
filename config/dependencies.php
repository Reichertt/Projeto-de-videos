<?php

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $dbPath = __DIR__ . '/../banco.sqlite';
        return new PDO("sqlite:$dbPath");
    },
    \League\Plates\Engine::class => function () {
        $templatePath = __DIR__ . '/../views';
        return new \League\Plates\Engine($templatePath);
    }
]);

// Outra maneira de executar o código, sendo o resultado o mesmo.

// $dbPath = __DIR__ . '/../banco.sqlite';
// $builder->addDefinitions([    
//     PDO::class => \DI\create(PDO::class)
//     ->constructor("sqlite:$dbPath"),
// ]);

/** @var \PSR\Container\ContainerInterface $container */
$container = $builder->build();

return $container;
