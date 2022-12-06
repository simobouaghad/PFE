<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512152930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendaretude (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, sale_id INT DEFAULT NULL, matire_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, INDEX IDX_126D5A6B7A45358C (groupe_id), INDEX IDX_126D5A6B4A7E4868 (sale_id), INDEX IDX_126D5A6B7652D06E (matire_id), INDEX IDX_126D5A6BBAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendaretude ADD CONSTRAINT FK_126D5A6B7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE calendaretude ADD CONSTRAINT FK_126D5A6B4A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE calendaretude ADD CONSTRAINT FK_126D5A6B7652D06E FOREIGN KEY (matire_id) REFERENCES matire (id)');
        $this->addSql('ALTER TABLE calendaretude ADD CONSTRAINT FK_126D5A6BBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calendaretude');
    }
}
