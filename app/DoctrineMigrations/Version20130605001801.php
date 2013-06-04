<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130605001801 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, exercise_id INT DEFAULT NULL, program_id INT DEFAULT NULL, `order` SMALLINT NOT NULL, INDEX IDX_C27C9369E934951A (exercise_id), INDEX IDX_C27C93693EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE stage ADD CONSTRAINT FK_C27C9369E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)");
        $this->addSql("ALTER TABLE stage ADD CONSTRAINT FK_C27C93693EB8070A FOREIGN KEY (program_id) REFERENCES program (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE stage");
    }
}
