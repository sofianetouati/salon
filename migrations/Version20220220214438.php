<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220214438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4584665A');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4C91BDE4');
        $this->addSql('ALTER TABLE booking CHANGE salon_id salon_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE coiffeur DROP FOREIGN KEY FK_C323A4F54C91BDE4');
        $this->addSql('ALTER TABLE coiffeur CHANGE salon_id salon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coiffeur ADD CONSTRAINT FK_C323A4F54C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE salon DROP FOREIGN KEY FK_F268F417783E3463');
        $this->addSql('ALTER TABLE salon CHANGE manager_id manager_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salon ADD CONSTRAINT FK_F268F417783E3463 FOREIGN KEY (manager_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4C91BDE4');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4584665A');
        $this->addSql('ALTER TABLE booking CHANGE salon_id salon_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE booker_fullname booker_fullname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE booker_email booker_email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE product_name product_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE color color VARCHAR(7) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE color color VARCHAR(7) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE coiffeur DROP FOREIGN KEY FK_C323A4F54C91BDE4');
        $this->addSql('ALTER TABLE coiffeur CHANGE salon_id salon_id INT NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE coiffeur ADD CONSTRAINT FK_C323A4F54C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE contact_form CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE message message LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duration duration VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:dateinterval)\', CHANGE detail detail VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE salon DROP FOREIGN KEY FK_F268F417783E3463');
        $this->addSql('ALTER TABLE salon CHANGE manager_id manager_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE salon ADD CONSTRAINT FK_F268F417783E3463 FOREIGN KEY (manager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
