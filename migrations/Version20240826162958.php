<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240826162958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create comment table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< sql
            CREATE TABLE comment (
                body LONGTEXT NOT NULL, 
                created_at DATETIME NOT NULL, 
                id INT AUTO_INCREMENT NOT NULL, 
                news_id INT DEFAULT NULL, 
                INDEX IDX_9474526CB5A459A0 (news_id), 
                PRIMARY KEY(id)
            )
        sql;
        $this->addSql($sql);
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB5A459A0');
        $this->addSql('DROP TABLE comment');
    }
}
