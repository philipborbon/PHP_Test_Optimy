<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Models;

use DateTimeInterface;

class Comment
{
    private int $id;

    private string $body;

    private DateTimeInterface $createdAt;

    private News $news;

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

    public function setNews(News $news): self
    {
        $this->news = $news;

        return $this;
    }

    public function getNews(): News
    {
        return $this->news;
    }
}
