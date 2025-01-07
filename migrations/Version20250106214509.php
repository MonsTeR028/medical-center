<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106214509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase ADD id_supp_id INT NOT NULL');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BCE737CBB FOREIGN KEY (id_supp_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_6117D13BCE737CBB ON purchase (id_supp_id)');
        $this->addSql('ALTER TABLE supplier DROP FOREIGN KEY FK_9B2A6C7E558FBEB9');
        $this->addSql('DROP INDEX IDX_9B2A6C7E558FBEB9 ON supplier');
        $this->addSql('ALTER TABLE supplier DROP purchase_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BCE737CBB');
        $this->addSql('DROP INDEX IDX_6117D13BCE737CBB ON purchase');
        $this->addSql('ALTER TABLE purchase DROP id_supp_id');
        $this->addSql('ALTER TABLE supplier ADD purchase_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7E558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('CREATE INDEX IDX_9B2A6C7E558FBEB9 ON supplier (purchase_id)');
    }
}
