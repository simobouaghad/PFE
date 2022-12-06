<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428011714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD category_id INT DEFAULT NULL, ADD sous_category_id INT DEFAULT NULL, ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3527FEED1 FOREIGN KEY (sous_category_id) REFERENCES sous_category (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_717E22E312469DE2 ON etudiant (category_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3527FEED1 ON etudiant (sous_category_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3A73F0036 ON etudiant (ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E312469DE2');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3527FEED1');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A73F0036');
        $this->addSql('DROP INDEX IDX_717E22E312469DE2 ON etudiant');
        $this->addSql('DROP INDEX IDX_717E22E3527FEED1 ON etudiant');
        $this->addSql('DROP INDEX IDX_717E22E3A73F0036 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP category_id, DROP sous_category_id, DROP ville_id');
    }
}
