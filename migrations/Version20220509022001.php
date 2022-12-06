<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509022001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD payement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3868C0609 ON etudiant (payement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3868C0609');
        $this->addSql('DROP INDEX IDX_717E22E3868C0609 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP payement_id');
    }
}
