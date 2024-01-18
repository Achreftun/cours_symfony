<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240117100051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_personne (sport_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_396C3655AC78BCF8 (sport_id), INDEX IDX_396C3655A21BD112 (personne_id), PRIMARY KEY(sport_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sport_personne ADD CONSTRAINT FK_396C3655AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sport_personne ADD CONSTRAINT FK_396C3655A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sport_personne DROP FOREIGN KEY FK_396C3655AC78BCF8');
        $this->addSql('ALTER TABLE sport_personne DROP FOREIGN KEY FK_396C3655A21BD112');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE sport_personne');
    }
}
