<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Tests\Unit\Models;

use DateTime;
use Optimy\PhpTestOptimy\Models\Comment;
use Optimy\PhpTestOptimy\Models\News;
use Optimy\PhpTestOptimy\Tests\Factory\NewsFactory;
use Optimy\PhpTestOptimy\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;

final class CommentTest extends UnitTestCase
{
    /**
     * @throws MockObjectException
     */
    public function testSettersAndGetters(): void
    {
        $comment = new Comment();

        $comment->setId(NewsFactory::COMMENT_ID);
        $this->assertSame(NewsFactory::COMMENT_ID, $comment->getId());

        $comment->setBody(NewsFactory::COMMENT);
        $this->assertSame(NewsFactory::COMMENT, $comment->getBody());

        $createdAt = new DateTime();
        $comment->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $comment->getCreatedAt());

        $news = $this->createMock(News::class);
        $comment->setNews($news);
        $this->assertSame($news, $comment->getNews());
    }
}
