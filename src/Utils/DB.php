<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Utils;

use PDO;

final class DB
{
	private $pdo;

	public function __construct($dsn, $user, $password)
	{
		$this->pdo = new PDO($dsn, $user, $password);
	}

	public function select($sql)
	{
		$sth = $this->pdo->query($sql);
		return $sth->fetchAll();
	}

	public function exec($sql)
	{
		return $this->pdo->exec($sql);
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}
