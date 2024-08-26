<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Seeders;

use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Optimy\PhpTestOptimy\Models\Comment;
use Optimy\PhpTestOptimy\Models\News;

final class NewsSeeder implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $items = [
            [
                'title' => 'news 1',
                'body' => 'this is the description of our fist news',
                'comments' => [
                    'i like this news',
                    'i have no opinion about that',
                    'are you kidding me ?',
                ],
            ],
            [
                'title' => 'news 2',
                'body' => 'this is the description of our second news',
                'comments' => [
                    'this is so true',
                    'trolololo',
                ],
            ],
            [
                'title' => 'news 3',
                'body' => 'this is the description of our third news',
                'comments' => [
                    'luke i am your father',
                ],
            ],
        ];

        foreach ($items as $item) {
            $news = new News();
            $news->setTitle($item['title']);
            $news->setBody($item['body']);
            $news->setCreatedAt(new DateTime());

            $manager->persist($news);
            $manager->flush();

            foreach ($item['comments'] as $commentStr) {
                $comment = new Comment();
                $comment->setBody($commentStr);
                $comment->setCreatedAt(new DateTime());
                $comment->setNews($news);

                $manager->persist($comment);
                $manager->flush();
            }
        }
    }
}
