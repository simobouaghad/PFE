<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513143741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE listnote (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, matire_id INT DEFAULT NULL, cne VARCHAR(255) NOT NULL, ds1 DOUBLE PRECISION DEFAULT NULL, ds2 DOUBLE PRECISION DEFAULT NULL, ds3 DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, INDEX IDX_93557FC37A45358C (groupe_id), INDEX IDX_93557FC37652D06E (matire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE listnote ADD CONSTRAINT FK_93557FC37A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE listnote ADD CONSTRAINT FK_93557FC37652D06E FOREIGN KEY (matire_id) REFERENCES matire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE listnote');
    }
}
