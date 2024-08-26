<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use Optimy\PhpTestOptimy\Models\Comment;

final class CommentManager
{
	public function __construct(private readonly DB $db)
	{
	}

	public function listComments()
	{
		$rows = $this->db->select('SELECT * FROM `comment`');

		$comments = [];
		foreach($rows as $row) {
			$n = new Comment();
			$comments[] = $n->setId($row['id'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at'])
			  ->setNewsId($row['news_id']);
		}

		return $comments;
	}

	public function addCommentForNews($body, $newsId)
	{
		$sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('". $body . "','" . date('Y-m-d') . "','" . $newsId . "')";
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	public function deleteComment($id)
	{
		$sql = "DELETE FROM `comment` WHERE `id`=" . $id;
		return $this->db->exec($sql);
	}
}
