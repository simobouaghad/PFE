<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513133642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gestionmatire (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, souscategory_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, matire_id INT DEFAULT NULL, prof_id INT DEFAULT NULL, INDEX IDX_E557296212469DE2 (category_id), INDEX IDX_E557296297753870 (souscategory_id), INDEX IDX_E55729627A45358C (groupe_id), INDEX IDX_E55729627652D06E (matire_id), INDEX IDX_E5572962ABC1F7FE (prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gestionmatire ADD CONSTRAINT FK_E557296212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE gestionmatire ADD CONSTRAINT FK_E557296297753870 FOREIGN KEY (souscategory_id) REFERENCES sous_category (id)');
        $this->addSql('ALTER TABLE gestionmatire ADD CONSTRAINT FK_E55729627A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE gestionmatire ADD CONSTRAINT FK_E55729627652D06E FOREIGN KEY (matire_id) REFERENCES matire (id)');
        $this->addSql('ALTER TABLE gestionmatire ADD CONSTRAINT FK_E5572962ABC1F7FE FOREIGN KEY (prof_id) REFERENCES professeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gestionmatire');
    }
}
