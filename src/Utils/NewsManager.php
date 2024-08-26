<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use DateTime;
use Exception;
use Optimy\PhpTestOptimy\Models\News;

final class NewsManager
{
	public function __construct(
        private readonly DB $db,
        private readonly CommentManager $commentManager,
    ){
	}

    /**
     * @return News[]
     * @throws Exception
     */
	public function listNews(): array
	{
		$rows = $this->db->select('SELECT * FROM `news`');

		$news = [];
		foreach($rows as $row) {
			$n = new News();
			$news[] = $n->setId($row['id'])
			  ->setTitle($row['title'])
			  ->setBody($row['body'])
			  ->setCreatedAt(new DateTime($row['created_at']));
		}

		return $news;
	}

	public function addNews(string $title, string $body): ?int
    {
		$sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('". $title . "','" . $body . "','" . date('Y-m-d') . "')";
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	public function deleteNews(int $id): int
    {
		$comments = $this->commentManager->listComments();
		$idsToDelete = [];

		foreach ($comments as $comment) {
			if ($comment->getNewsId() == $id) {
				$idsToDelete[] = $comment->getId();
			}
		}

		foreach($idsToDelete as $id) {
			$this->commentManager->deleteComment($id);
		}

		$sql = "DELETE FROM `news` WHERE `id`=" . $id;
		return $this->db->exec($sql);
	}
}
