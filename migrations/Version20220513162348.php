<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513162348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listnote ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE listnote ADD CONSTRAINT FK_93557FC3613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_93557FC3613FECDF ON listnote (session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listnote DROP FOREIGN KEY FK_93557FC3613FECDF');
        $this->addSql('DROP INDEX IDX_93557FC3613FECDF ON listnote');
        $this->addSql('ALTER TABLE listnote DROP session_id');
    }
}
