<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623172450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exams ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exams ADD CONSTRAINT FK_69311328463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_69311328463CD7C3 ON exams (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exams DROP FOREIGN KEY FK_69311328463CD7C3');
        $this->addSql('DROP INDEX IDX_69311328463CD7C3 ON exams');
        $this->addSql('ALTER TABLE exams DROP centre_id');
    }
}
