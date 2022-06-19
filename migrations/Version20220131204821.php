<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131204821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salon ADD manager_id INT NOT NULL');
        $this->addSql('ALTER TABLE salon ADD CONSTRAINT FK_F268F417783E3463 FOREIGN KEY (manager_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F268F417783E3463 ON salon (manager_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salon DROP FOREIGN KEY FK_F268F417783E3463');
        $this->addSql('DROP INDEX UNIQ_F268F417783E3463 ON salon');
        $this->addSql('ALTER TABLE salon DROP manager_id');
    }
}
