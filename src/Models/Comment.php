<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Models;

use DateTimeInterface;

final class Comment
{
    private int $id;
    private string $body;
    private DateTimeInterface $createdAt;
    private int $newsId;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getNewsId(): int
    {
        return $this->newsId;
    }

    public function setNewsId(int $newsId): self
    {
        $this->newsId = $newsId;

        return $this;
    }
}
