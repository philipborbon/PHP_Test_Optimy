<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240826162954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create news table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< sql
            CREATE TABLE news (
                title VARCHAR(511) NOT NULL, 
                body LONGTEXT NOT NULL, 
                created_at DATETIME NOT NULL, 
                id INT AUTO_INCREMENT NOT NULL, 
                PRIMARY KEY(id)
            )
        sql;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE news');
    }
}
