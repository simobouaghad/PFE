<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428004828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe ADD centre_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD sous_category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C2112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21463CD7C3 ON groupe (centre_id)');
        $this->addSql('CREATE INDEX IDX_4B98C2112469DE2 ON groupe (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21463CD7C3');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C2112469DE2');
        $this->addSql('DROP INDEX IDX_4B98C21463CD7C3 ON groupe');
        $this->addSql('DROP INDEX IDX_4B98C2112469DE2 ON groupe');
        $this->addSql('ALTER TABLE groupe DROP centre_id, DROP category_id, DROP sous_category');
    }
}
