<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110092700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD delivery_adresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939853A24B78 FOREIGN KEY (delivery_adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_F529939853A24B78 ON `order` (delivery_adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939853A24B78');
        $this->addSql('DROP INDEX IDX_F529939853A24B78 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP delivery_adresse_id');
    }
}
