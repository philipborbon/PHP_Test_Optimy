<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Optimy\PhpTestOptimy\Utils\CommentManager;
use Optimy\PhpTestOptimy\Utils\NewsManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();

$dbConnectionParams = (new DsnParser())
    ->parse($_ENV['DB_DSN'] ?? null);

$mappingDriver = new SimplifiedXmlDriver(
    prefixes: [
        __DIR__ . '/../src/Persistence/Mapping' => 'Optimy\PhpTestOptimy\Models',
    ],
    isXsdValidationEnabled: false
);

$dbConfig = ORMSetup::createXMLMetadataConfiguration([
    __DIR__ . '/../src/Persistence/Mapping',
], boolval($_ENV['IS_DEV'] ?? false));
$dbConfig->setMetadataDriverImpl($mappingDriver);
$dbConfig->setNamingStrategy(new UnderscoreNamingStrategy());

$dbConnection = DriverManager::getConnection($dbConnectionParams, $dbConfig);

$container->register(CommentManager::class, CommentManager::class)
    ->addArgument(new Reference(EntityManager::class));

$container->register(NewsManager::class, NewsManager::class)
    ->addArgument(new Reference(EntityManager::class))
    ->addArgument(new Reference(CommentManager::class));

$container->register(EntityManager::class, EntityManager::class)
    ->addArgument($dbConnection)
    ->addArgument($dbConfig);

return $container;
