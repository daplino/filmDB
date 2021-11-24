<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211124134938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE action (code VARCHAR(25) NOT NULL, PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, work_id INT NOT NULL, project_id INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_AC74095ABB3453DB (work_id), INDEX IDX_AC74095A166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audience (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(2) DEFAULT NULL, name VARCHAR(255) NOT NULL, pic INT NOT NULL, INDEX IDX_4FBF094F5373C966 (country), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_project (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, activity_type VARCHAR(255) NOT NULL, min_nb_activities SMALLINT NOT NULL, max_nb_activites SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (code VARCHAR(2) NOT NULL, PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crew (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, person_id INT DEFAULT NULL, work_id INT DEFAULT NULL, points INT DEFAULT NULL, INDEX IDX_894940B2D60322AC (role_id), INDEX IDX_894940B2217BBB47 (person_id), INDEX IDX_894940B2BB3453DB (work_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT NOT NULL, length VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work (id INT AUTO_INCREMENT NOT NULL, audience INT DEFAULT NULL, country VARCHAR(2) DEFAULT NULL, title VARCHAR(255) NOT NULL, year_of_copyright VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_534E6880FDCD9418 (audience), INDEX IDX_534E68805373C966 (country), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_genre (work_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_ABAB48D7BB3453DB (work_id), UNIQUE INDEX UNIQ_ABAB48D74296D31F (genre_id), PRIMARY KEY(work_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, work_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, gender VARCHAR(255) NOT NULL, nationality VARCHAR(255) DEFAULT NULL, residence VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production (id INT AUTO_INCREMENT NOT NULL, company INT NOT NULL, role_id INT NOT NULL, work_id INT DEFAULT NULL, share DOUBLE PRECISION NOT NULL, INDEX IDX_D3EDB1E04FBF094F (company), INDEX IDX_D3EDB1E0D60322AC (role_id), INDEX IDX_D3EDB1E0BB3453DB (work_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(25) DEFAULT NULL, company INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, round INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, decision VARCHAR(255) DEFAULT NULL, INDEX IDX_2FB3D0EE47CC8C92 (action), INDEX IDX_2FB3D0EE4FBF094F (company), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_project (user_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_77BECEE4A76ED395 (user_id), INDEX IDX_77BECEE4166D1F9C (project_id), PRIMARY KEY(user_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_game (id INT NOT NULL, test INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095ABB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F5373C966 FOREIGN KEY (country) REFERENCES country (code)');
        $this->addSql('ALTER TABLE crew ADD CONSTRAINT FK_894940B2D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE crew ADD CONSTRAINT FK_894940B2217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE crew ADD CONSTRAINT FK_894940B2BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22BF396750 FOREIGN KEY (id) REFERENCES work (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E6880FDCD9418 FOREIGN KEY (audience) REFERENCES audience (id)');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E68805373C966 FOREIGN KEY (country) REFERENCES country (code)');
        $this->addSql('ALTER TABLE work_genre ADD CONSTRAINT FK_ABAB48D7BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE work_genre ADD CONSTRAINT FK_ABAB48D74296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E04FBF094F FOREIGN KEY (company) REFERENCES company (id)');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E0D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E0BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE47CC8C92 FOREIGN KEY (action) REFERENCES action (code)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE4FBF094F FOREIGN KEY (company) REFERENCES company (id)');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT FK_77BECEE4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT FK_77BECEE4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_game ADD CONSTRAINT FK_24BC6C50BF396750 FOREIGN KEY (id) REFERENCES work (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE47CC8C92');
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E6880FDCD9418');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E04FBF094F');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE4FBF094F');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F5373C966');
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E68805373C966');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095ABB3453DB');
        $this->addSql('ALTER TABLE crew DROP FOREIGN KEY FK_894940B2BB3453DB');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22BF396750');
        $this->addSql('ALTER TABLE work_genre DROP FOREIGN KEY FK_ABAB48D7BB3453DB');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E0BB3453DB');
        $this->addSql('ALTER TABLE video_game DROP FOREIGN KEY FK_24BC6C50BF396750');
        $this->addSql('ALTER TABLE work_genre DROP FOREIGN KEY FK_ABAB48D74296D31F');
        $this->addSql('ALTER TABLE crew DROP FOREIGN KEY FK_894940B2217BBB47');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A166D1F9C');
        $this->addSql('ALTER TABLE user_project DROP FOREIGN KEY FK_77BECEE4166D1F9C');
        $this->addSql('ALTER TABLE crew DROP FOREIGN KEY FK_894940B2D60322AC');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E0D60322AC');
        $this->addSql('ALTER TABLE user_project DROP FOREIGN KEY FK_77BECEE4A76ED395');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE audience');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE config_project');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE crew');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE work');
        $this->addSql('DROP TABLE work_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE production');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_project');
        $this->addSql('DROP TABLE video_game');
    }
}
