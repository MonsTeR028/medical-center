<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210084206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medicine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(20) NOT NULL, dosage VARCHAR(10) NOT NULL, price_unit DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine_medicine_category (medicine_id INT NOT NULL, medicine_category_id INT NOT NULL, INDEX IDX_923DA94E2F7D140A (medicine_id), INDEX IDX_923DA94E7AC78750 (medicine_category_id), PRIMARY KEY(medicine_id, medicine_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicine_medicine_category ADD CONSTRAINT FK_923DA94E2F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine_medicine_category ADD CONSTRAINT FK_923DA94E7AC78750 FOREIGN KEY (medicine_category_id) REFERENCES medicine_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine_medicine_category DROP FOREIGN KEY FK_923DA94E2F7D140A');
        $this->addSql('ALTER TABLE medicine_medicine_category DROP FOREIGN KEY FK_923DA94E7AC78750');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE medicine_medicine_category');
        $this->addSql('DROP TABLE medicine_category');
    }
}
