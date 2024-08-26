<?php

declare(strict_types=1);

use Optimy\PhpTestOptimy\App;
use Optimy\PhpTestOptimy\Utils\CommentManager;
use Optimy\PhpTestOptimy\Utils\NewsManager;

/** @var App $app */
$app = require __DIR__ . '/bootstrap.php';

/** @var CommentManager $commentManager */
$commentManager = $app->getContainer()->get(CommentManager::class);

/** @var NewsManager $newsManager */
$newsManager = $app->getContainer()->get(NewsManager::class);

foreach ($newsManager->listNews() as $news) {
    echo("############ NEWS " . $news->getTitle() . " ############\n");
    echo($news->getBody() . "\n");
    foreach ($news->getComments() as $comment) {
        echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
    }
}

$c = $commentManager->listComments();
