<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531101205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur ADD grade_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C5FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('CREATE INDEX IDX_FD71A9C5FE19A1A8 ON joueur (grade_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C5FE19A1A8');
        $this->addSql('DROP INDEX IDX_FD71A9C5FE19A1A8 ON joueur');
        $this->addSql('ALTER TABLE joueur DROP grade_id, CHANGE created_at created_at DATETIME DEFAULT \'now()\'');
    }
}
