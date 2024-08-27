<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Tests\Integration\Utils;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Optimy\PhpTestOptimy\Models\Comment;
use Optimy\PhpTestOptimy\Tests\Factory\NewsFactory;
use Optimy\PhpTestOptimy\Tests\Integration\IntegrationTestCase;
use Optimy\PhpTestOptimy\Utils\CommentManager;
use Optimy\PhpTestOptimy\Utils\NewsManager;

final class CommentManagerTest extends IntegrationTestCase
{
    private CommentManager $commentManager;

    private NewsManager $newsManager;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CommentManager $commentManager */
        $commentManager = $this->getContainer()->get(CommentManager::class);
        $this->commentManager = $commentManager;

        /** @var NewsManager $newsManager */
        $newsManager = $this->getContainer()->get(NewsManager::class);
        $this->newsManager = $newsManager;
    }

    public function testListNews(): void
    {
        $commentList = $this->commentManager->listComments();
        $this->assertCount(6, $commentList);

        /** @var Comment $comment */
        $comment = current($commentList);

        $this->assertSame(NewsFactory::COMMENT_0_ID, $comment->getId());
        $this->assertSame(NewsFactory::COMMENT_0_BODY, $comment->getBody());
        $this->assertSame(NewsFactory::NEWS_0_ID, $comment->getNews()->getId());
    }

    /**
     * @throws ORMException
     */
    public function testAddCommentForNews(): void
    {
        $commentList = $this->commentManager->listComments();
        $this->assertCount(6, $commentList);

        /** @var Comment $last */
        $last = end($commentList);

        $news = $this->newsManager->getNews(NewsFactory::NEWS_0_ID);
        $this->assertCount(3, $news->getComments());

        $comment = $this->commentManager->addCommentForNews(NewsFactory::COMMENT, NewsFactory::NEWS_0_ID);

        $commentList = $this->commentManager->listComments();
        $this->assertCount(7, $commentList);

        $this->assertCount(4, $news->getComments());

        $this->assertSame($last->getId() + 1, $comment->getId());
        $this->assertSame(NewsFactory::COMMENT, $comment->getBody());
    }

    /**
     * @throws ORMException
     */
    public function testAddCommentForNewsForNonExistingNewsId(): void
    {
        $this->expectException(EntityNotFoundException::class);
        $this->commentManager->addCommentForNews(NewsFactory::COMMENT, 77);
    }

    public function testDeleteComment(): void
    {
        $commentList = $this->commentManager->listComments();
        $this->assertCount(7, $commentList);

        /** @var Comment $toBeDeletedComment */
        $toBeDeletedComment = current($commentList);

        $news = $this->newsManager->getNews($toBeDeletedComment->getId());
        $this->assertCount(4, $news->getComments());

        $toBeDeletedCommentId = $toBeDeletedComment->getId();

        $this->commentManager->deleteComment($toBeDeletedCommentId);

        $commentList = $this->commentManager->listComments();
        $this->assertCount(6, $commentList);

        $this->assertCount(3, $news->getComments());

        $commentIds = array_map(fn(Comment $comment) => $comment->getId(), $commentList);

        $this->assertNotContains($toBeDeletedCommentId, $commentIds);
    }

    public function testDeleteWithNonExistingId(): void
    {
        $this->expectException(EntityNotFoundException::class);
        $this->commentManager->deleteComment(77);
    }
}
