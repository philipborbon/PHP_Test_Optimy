<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Optimy\PhpTestOptimy\Models\Comment;
use Optimy\PhpTestOptimy\Models\News;

final class CommentManager
{
    private EntityRepository $newsRepository;

    private EntityRepository $commentRepository;

	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
        $this->newsRepository = $this->entityManager->getRepository(News::class);
        $this->commentRepository = $this->entityManager->getRepository(Comment::class);
	}

    /**
     * @return Comment[]
     */
	public function listComments(): array
	{
        return $this->commentRepository->findAll();
	}

    /**
     * @throws ORMException
     */
    public function addCommentForNews(string $body, int $newsId): Comment
    {
        /** @var ?News $news */
        $news = $this->newsRepository->find($newsId);

        if (null === $news) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(News::class, [$newsId]);
        }

        $comment = new Comment();
        $comment->setBody($body);
        $comment->setCreatedAt(new DateTime());
        $comment->setNews($news);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        $this->entityManager->refresh($news);

        return $comment;
	}

	public function deleteComment(int $id): void
    {
        /** @var Comment $comment */
        $comment = $this->commentRepository->find($id);

        if (null === $comment) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Comment::class, [$id]);
        }

        $this->entityManager->remove($comment);
        $this->entityManager->flush();
	}
}
