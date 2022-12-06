<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508232431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE methdepay ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE methdepay ADD CONSTRAINT FK_4E2A881F463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_4E2A881F463CD7C3 ON methdepay (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE methdepay DROP FOREIGN KEY FK_4E2A881F463CD7C3');
        $this->addSql('DROP INDEX IDX_4E2A881F463CD7C3 ON methdepay');
        $this->addSql('ALTER TABLE methdepay DROP centre_id');
    }
}
