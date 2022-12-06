<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513163037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gestionmatire ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gestionmatire ADD CONSTRAINT FK_E5572962613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_E5572962613FECDF ON gestionmatire (session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gestionmatire DROP FOREIGN KEY FK_E5572962613FECDF');
        $this->addSql('DROP INDEX IDX_E5572962613FECDF ON gestionmatire');
        $this->addSql('ALTER TABLE gestionmatire DROP session_id');
    }
}
