<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240117124508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP INDEX UNIQ_FCEC9EF4DE7DC5C, ADD INDEX IDX_FCEC9EF4DE7DC5C (adresse_id)');
        $this->addSql('ALTER TABLE personne ADD type VARCHAR(255) NOT NULL, ADD niveau VARCHAR(255) DEFAULT NULL, ADD salaire INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP INDEX IDX_FCEC9EF4DE7DC5C, ADD UNIQUE INDEX UNIQ_FCEC9EF4DE7DC5C (adresse_id)');
        $this->addSql('ALTER TABLE personne DROP type, DROP niveau, DROP salaire');
    }
}
