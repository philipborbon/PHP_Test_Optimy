<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Models;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class News
{
    private int $id;

    private string $title;

    private string $body;

    private DateTimeInterface $createdAt;

    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments(array $comments): self
    {
        $this->comments->clear();
        foreach ($comments as $comment) {
            $this->comments->add($comment);
        }

        return $this;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments->toArray();
    }
}
