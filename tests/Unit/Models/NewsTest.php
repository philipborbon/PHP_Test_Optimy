<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Tests\Unit\Models;

use DateTime;
use Optimy\PhpTestOptimy\Models\Comment;
use Optimy\PhpTestOptimy\Models\News;
use Optimy\PhpTestOptimy\Tests\Factory\NewsFactory;
use Optimy\PhpTestOptimy\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\Exception as MockObjectException;

final class NewsTest extends UnitTestCase
{
    /**
     * @throws MockObjectException
     */
    public function testSettersAndGetters(): void
    {
        $news = new News();

        $news->setId(NewsFactory::NEWS_ID);
        $this->assertEquals(NewsFactory::NEWS_ID, $news->getId());

        $news->setTitle(NewsFactory::NEWS_TITLE);
        $this->assertEquals(NewsFactory::NEWS_TITLE, $news->getTitle());

        $news->setBody(NewsFactory::NEWS_BODY);
        $this->assertequals(NewsFactory::NEWS_BODY, $news->getBody());

        $createdAt = new DateTime();
        $news->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $news->getCreatedAt());

        $comments = [$this->createMock(Comment::class)];
        $news->setComments($comments);
        $this->assertSame($comments, $news->getComments());
    }
}
