<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130626145307 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, comment LONGTEXT NOT NULL, difficulty SMALLINT DEFAULT NULL, INDEX IDX_D044D5D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, exercise_id INT DEFAULT NULL, session_id INT DEFAULT NULL, done TINYINT(1) DEFAULT NULL, grade SMALLINT DEFAULT NULL, position SMALLINT NOT NULL, sets SMALLINT NOT NULL, number SMALLINT NOT NULL, unit VARCHAR(20) NOT NULL, difficulty SMALLINT NOT NULL, difficultyUnit VARCHAR(20) NOT NULL, INDEX IDX_649FFB72E934951A (exercise_id), INDEX IDX_649FFB72613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)");
        $this->addSql("ALTER TABLE workout ADD CONSTRAINT FK_649FFB72E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)");
        $this->addSql("ALTER TABLE workout ADD CONSTRAINT FK_649FFB72613FECDF FOREIGN KEY (session_id) REFERENCES session (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72613FECDF");
        $this->addSql("DROP TABLE session");
        $this->addSql("DROP TABLE workout");
    }
}
