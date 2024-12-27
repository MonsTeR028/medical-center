<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241227144914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE batch_medicine (id INT AUTO_INCREMENT NOT NULL, id_med_id INT NOT NULL, quantity INT NOT NULL, expiration_date DATE NOT NULL, arrival_date DATE NOT NULL, purchase_price DOUBLE PRECISION NOT NULL, INDEX IDX_D3D844ED5F098C81 (id_med_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE batch_medicine ADD CONSTRAINT FK_D3D844ED5F098C81 FOREIGN KEY (id_med_id) REFERENCES medicine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE batch_medicine DROP FOREIGN KEY FK_D3D844ED5F098C81');
        $this->addSql('DROP TABLE batch_medicine');
    }
}
