<?php

declare(strict_types=1);

use Optimy\PhpTestOptimy\Utils\CommentManager;
use Optimy\PhpTestOptimy\Utils\DB;
use Optimy\PhpTestOptimy\Utils\NewsManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();

$container->register(DB::class, DB::class)
    ->addArgument($_ENV['DB_DSN'] ?? null)
    ->addArgument($_ENV['DB_USER'] ?? null)
    ->addArgument($_ENV['DB_PASS']);

$container->register(CommentManager::class, CommentManager::class)
    ->addArgument(new Reference(DB::class));

$container->register(NewsManager::class, NewsManager::class)
    ->addArgument(new Reference(DB::class))
    ->addArgument(new Reference(CommentManager::class));

return $container;
