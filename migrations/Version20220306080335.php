<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220306080335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidats_hobbies (candidats_id INT NOT NULL, hobbies_id INT NOT NULL, INDEX IDX_68C1A247E4CF8FC2 (candidats_id), INDEX IDX_68C1A247B2242D72 (hobbies_id), PRIMARY KEY(candidats_id, hobbies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobbies (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profiles (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, rs VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidats_hobbies ADD CONSTRAINT FK_68C1A247E4CF8FC2 FOREIGN KEY (candidats_id) REFERENCES candidats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidats_hobbies ADD CONSTRAINT FK_68C1A247B2242D72 FOREIGN KEY (hobbies_id) REFERENCES hobbies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidats ADD profiles_id INT DEFAULT NULL, ADD jobs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidats ADD CONSTRAINT FK_3C663B1522077C89 FOREIGN KEY (profiles_id) REFERENCES profiles (id)');
        $this->addSql('ALTER TABLE candidats ADD CONSTRAINT FK_3C663B1548704627 FOREIGN KEY (jobs_id) REFERENCES jobs (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C663B1522077C89 ON candidats (profiles_id)');
        $this->addSql('CREATE INDEX IDX_3C663B1548704627 ON candidats (jobs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidats_hobbies DROP FOREIGN KEY FK_68C1A247B2242D72');
        $this->addSql('ALTER TABLE candidats DROP FOREIGN KEY FK_3C663B1548704627');
        $this->addSql('ALTER TABLE candidats DROP FOREIGN KEY FK_3C663B1522077C89');
        $this->addSql('DROP TABLE candidats_hobbies');
        $this->addSql('DROP TABLE hobbies');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE profiles');
        $this->addSql('DROP INDEX UNIQ_3C663B1522077C89 ON candidats');
        $this->addSql('DROP INDEX IDX_3C663B1548704627 ON candidats');
        $this->addSql('ALTER TABLE candidats DROP profiles_id, DROP jobs_id, CHANGE firstname firstname VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
