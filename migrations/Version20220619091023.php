<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220619091023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, centre_id INT DEFAULT NULL, category_id INT DEFAULT NULL, souscategory_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, planning VARCHAR(255) NOT NULL, INDEX IDX_D499BFF6463CD7C3 (centre_id), INDEX IDX_D499BFF612469DE2 (category_id), INDEX IDX_D499BFF697753870 (souscategory_id), INDEX IDX_D499BFF67A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF697753870 FOREIGN KEY (souscategory_id) REFERENCES sous_category (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF67A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE planning');
    }
}
