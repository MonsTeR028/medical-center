<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111172731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine_category ADD color VARCHAR(6) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912469DE2 FOREIGN KEY (category_id) REFERENCES medicine_category (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64912469DE2 ON user (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine_category DROP color');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912469DE2');
        $this->addSql('DROP INDEX IDX_8D93D64912469DE2 ON user');
        $this->addSql('ALTER TABLE user DROP category_id');
    }
}
