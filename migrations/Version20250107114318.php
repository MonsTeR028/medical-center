<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107114318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine_medicine_category DROP FOREIGN KEY FK_923DA94E2F7D140A');
        $this->addSql('ALTER TABLE medicine_medicine_category DROP FOREIGN KEY FK_923DA94E7AC78750');
        $this->addSql('DROP TABLE medicine_medicine_category');
        $this->addSql('ALTER TABLE medicine ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medicine ADD CONSTRAINT FK_58362A8D12469DE2 FOREIGN KEY (category_id) REFERENCES medicine_category (id)');
        $this->addSql('CREATE INDEX IDX_58362A8D12469DE2 ON medicine (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medicine_medicine_category (medicine_id INT NOT NULL, medicine_category_id INT NOT NULL, INDEX IDX_923DA94E2F7D140A (medicine_id), INDEX IDX_923DA94E7AC78750 (medicine_category_id), PRIMARY KEY(medicine_id, medicine_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE medicine_medicine_category ADD CONSTRAINT FK_923DA94E2F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine_medicine_category ADD CONSTRAINT FK_923DA94E7AC78750 FOREIGN KEY (medicine_category_id) REFERENCES medicine_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine DROP FOREIGN KEY FK_58362A8D12469DE2');
        $this->addSql('DROP INDEX IDX_58362A8D12469DE2 ON medicine');
        $this->addSql('ALTER TABLE medicine DROP category_id');
    }
}
