<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use DateTime;
use Exception;
use Optimy\PhpTestOptimy\Models\Comment;

final class CommentManager
{
	public function __construct(private readonly DB $db)
	{
	}

    /**
     * @return Comment[]
     * @throws Exception
     */
	public function listComments(): array
	{
		$rows = $this->db->select('SELECT * FROM `comment`');

		$comments = [];
		foreach($rows as $row) {
			$n = new Comment();
			$comments[] = $n->setId($row['id'])
			  ->setBody($row['body'])
			  ->setCreatedAt(new DateTime($row['created_at']))
			  ->setNewsId($row['news_id']);
		}

		return $comments;
	}

	public function addCommentForNews(string $body, int $newsId): ?int
    {
		$sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('". $body . "','" . date('Y-m-d') . "','" . $newsId . "')";
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	public function deleteComment(int $id): int
    {
		$sql = "DELETE FROM `comment` WHERE `id`=" . $id;
		return $this->db->exec($sql);
	}
}
