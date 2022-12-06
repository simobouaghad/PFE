<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623172245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exams (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, sous_category_id INT DEFAULT NULL, examplan VARCHAR(255) NOT NULL, INDEX IDX_6931132812469DE2 (category_id), INDEX IDX_69311328527FEED1 (sous_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exams ADD CONSTRAINT FK_6931132812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE exams ADD CONSTRAINT FK_69311328527FEED1 FOREIGN KEY (sous_category_id) REFERENCES sous_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE exams');
    }
}
