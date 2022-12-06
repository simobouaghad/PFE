<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428210551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matire ADD centre_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD sous_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matire ADD CONSTRAINT FK_2270AA1D463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE matire ADD CONSTRAINT FK_2270AA1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE matire ADD CONSTRAINT FK_2270AA1D527FEED1 FOREIGN KEY (sous_category_id) REFERENCES sous_category (id)');
        $this->addSql('CREATE INDEX IDX_2270AA1D463CD7C3 ON matire (centre_id)');
        $this->addSql('CREATE INDEX IDX_2270AA1D12469DE2 ON matire (category_id)');
        $this->addSql('CREATE INDEX IDX_2270AA1D527FEED1 ON matire (sous_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matire DROP FOREIGN KEY FK_2270AA1D463CD7C3');
        $this->addSql('ALTER TABLE matire DROP FOREIGN KEY FK_2270AA1D12469DE2');
        $this->addSql('ALTER TABLE matire DROP FOREIGN KEY FK_2270AA1D527FEED1');
        $this->addSql('DROP INDEX IDX_2270AA1D463CD7C3 ON matire');
        $this->addSql('DROP INDEX IDX_2270AA1D12469DE2 ON matire');
        $this->addSql('DROP INDEX IDX_2270AA1D527FEED1 ON matire');
        $this->addSql('ALTER TABLE matire DROP centre_id, DROP category_id, DROP sous_category_id');
    }
}
