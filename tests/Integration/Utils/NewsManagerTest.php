<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Tests\Integration\Utils;

use Doctrine\ORM\EntityNotFoundException;
use Optimy\PhpTestOptimy\Models\Comment;
use Optimy\PhpTestOptimy\Models\News;
use Optimy\PhpTestOptimy\Tests\Factory\NewsFactory;
use Optimy\PhpTestOptimy\Tests\Integration\IntegrationTestCase;
use Optimy\PhpTestOptimy\Utils\CommentManager;
use Optimy\PhpTestOptimy\Utils\NewsManager;

final class NewsManagerTest extends IntegrationTestCase
{
    private NewsManager $newsManager;

    private CommentManager $commentManager;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var NewsManager $newsManager */
        $newsManager = $this->getContainer()->get(NewsManager::class);
        $this->newsManager = $newsManager;

        /** @var CommentManager $commentManager */
        $commentManager = $this->getContainer()->get(CommentManager::class);
        $this->commentManager = $commentManager;
    }

    public function testGetNews(): void
    {
        $news = $this->newsManager->getNews(NewsFactory::NEWS_0_ID);

        $this->assertSame(NewsFactory::NEWS_0_ID, $news->getId());
        $this->assertSame(NewsFactory::NEWS_0_TITLE, $news->getTitle());
        $this->assertSame(NewsFactory::NEWS_0_BODY, $news->getBody());
    }

    public function testGetNewsWithNonExistingId(): void
    {
        $news = $this->newsManager->getNews(77);
        $this->assertNull($news);
    }

    public function testListNews(): void
    {
        $newsList = $this->newsManager->listNews();
        $this->assertCount(3, $newsList);

        /** @var News $news */
        $news = current($newsList);

        $this->assertSame(NewsFactory::NEWS_0_ID, $news->getId());
        $this->assertSame(NewsFactory::NEWS_0_TITLE, $news->getTitle());
        $this->assertSame(NewsFactory::NEWS_0_BODY, $news->getBody());
    }

    public function testAddNews(): void
    {
        $newsList = $this->newsManager->listNews();
        $this->assertCount(3, $newsList);

        /** @var News $last */
        $last = end($newsList);

        $news = $this->newsManager->addNews(NewsFactory::NEWS_TITLE, NewsFactory::NEWS_BODY);

        $newsList = $this->newsManager->listNews();
        $this->assertCount(4, $newsList);

        $this->assertSame($last->getId() + 1, $news->getId());
        $this->assertSame(NewsFactory::NEWS_TITLE, $news->getTitle());
        $this->assertSame(NewsFactory::NEWS_BODY, $news->getBody());
    }

    public function testDeleteNews(): void
    {
        $newsList = $this->newsManager->listNews();
        $this->assertCount(4, $newsList);

        /** @var News $toBeDeletedNews */
        $toBeDeletedNews = current($newsList);

        $toBeDeletedComments = $toBeDeletedNews->getComments();
        $this->assertCount(3, $toBeDeletedComments);

        $allComments = $this->commentManager->listComments();
        $this->assertCount(6, $allComments);

        $toBeDeletedCommentIds = array_map(fn(Comment $comment) => $comment->getId(), $toBeDeletedComments);
        $toBeDeletedNewsId = $toBeDeletedNews->getId();

        $this->newsManager->deleteNews($toBeDeletedNewsId);

        $newsList = $this->newsManager->listNews();
        $this->assertCount(3, $newsList);

        $allComments = $this->commentManager->listComments();
        $this->assertCount(3, $allComments);

        $remainingNewsIds = array_map(fn(News $news) => $news->getId(), $newsList);
        $remainingCommentIds = array_map(fn(Comment $comment) => $comment->getId(), $allComments);

        $this->assertNotContains($toBeDeletedNewsId, $remainingNewsIds);

        foreach ($toBeDeletedCommentIds as $deletedCommentId) {
            $this->assertNotContains($deletedCommentId, $remainingCommentIds);
        }
    }

    public function testDeleteNewsWithNonExistingId(): void
    {
        $this->expectException(EntityNotFoundException::class);
        $this->newsManager->deleteNews(77);
    }
}
