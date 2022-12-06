<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616101100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lessons (id INT AUTO_INCREMENT NOT NULL, centre_id INT DEFAULT NULL, category_id INT DEFAULT NULL, sous_category_id INT DEFAULT NULL, matire_id INT DEFAULT NULL, lesson VARCHAR(255) NOT NULL, INDEX IDX_3F4218D9463CD7C3 (centre_id), INDEX IDX_3F4218D912469DE2 (category_id), INDEX IDX_3F4218D9527FEED1 (sous_category_id), INDEX IDX_3F4218D97652D06E (matire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D9463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D9527FEED1 FOREIGN KEY (sous_category_id) REFERENCES sous_category (id)');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D97652D06E FOREIGN KEY (matire_id) REFERENCES matire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lessons');
    }
}
