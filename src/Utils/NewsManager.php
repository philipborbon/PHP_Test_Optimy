<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Optimy\PhpTestOptimy\Models\News;

final class NewsManager
{
    private EntityRepository $repository;

	public function __construct(private readonly EntityManagerInterface $entityManager){
        $this->repository = $entityManager->getRepository(News::class);
	}

    public function getNews(int $id): ?News
    {
        return $this->repository->find($id);
    }

    /**
     * @return News[]
     */
	public function listNews(): array
	{
        return $this->repository->findAll();
	}

	public function addNews(string $title, string $body): News
    {
        $news = new News();
        $news->setTitle($title);
        $news->setBody($body);
        $news->setCreatedAt(new DateTime());

        $this->entityManager->persist($news);
        $this->entityManager->flush();

        return $news;
	}

	public function deleteNews(int $id): void
    {
        /** @var News $news */
        $news = $this->repository->find($id);

        $this->entityManager->remove($news);
        $this->entityManager->flush();
	}
}
