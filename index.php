<?php

use Optimy\PhpTestOptimy\Utils\CommentManager;
use Optimy\PhpTestOptimy\Utils\NewsManager;

require 'bootstrap.php';

foreach (NewsManager::getInstance()->listNews() as $news) {
    echo("############ NEWS " . $news->getTitle() . " ############\n");
    echo($news->getBody() . "\n");
    foreach (CommentManager::getInstance()->listComments() as $comment) {
        if ($comment->getNewsId() == $news->getId()) {
            echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
        }
    }
}

$commentManager = CommentManager::getInstance();
$c = $commentManager->listComments();
