<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618122727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE toto (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, year_of_copyright INT DEFAULT NULL, test INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crew ADD work_id INT NOT NULL, DROP n');
        $this->addSql('ALTER TABLE crew ADD CONSTRAINT FK_894940B2BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('CREATE INDEX IDX_894940B2BB3453DB ON crew (work_id)');
        $this->addSql('ALTER TABLE work CHANGE year_of_copyright year_of_copyright INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE toto');
        $this->addSql('DROP TABLE video_game');
        $this->addSql('ALTER TABLE crew DROP FOREIGN KEY FK_894940B2BB3453DB');
        $this->addSql('DROP INDEX IDX_894940B2BB3453DB ON crew');
        $this->addSql('ALTER TABLE crew ADD n VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP work_id');
        $this->addSql('ALTER TABLE work CHANGE year_of_copyright year_of_copyright DATE DEFAULT NULL');
    }
}
