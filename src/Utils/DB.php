<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use PDO;

final class DB
{
	private PDO $pdo;

	public function __construct(string $dsn, string $user, string $password)
	{
		$this->pdo = new PDO($dsn, $user, $password);
	}

	public function select(string $sql): array
	{
		$statement = $this->pdo->query($sql);
		return $statement->fetchAll();
	}

	public function exec(string $sql): int
	{
		$affectedRows = $this->pdo->exec($sql);

        if (false === $affectedRows) {
            return 0;
        }

        return $affectedRows;
	}

	public function lastInsertId(): ?int
	{
        $lastInsertedId = $this->pdo->lastInsertId();

        if (false === $lastInsertedId) {
            return null;
        }

        return (int) $lastInsertedId;
	}
}
