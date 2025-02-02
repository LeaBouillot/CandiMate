<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130172107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cover_letter CHANGE job_offer_id job_offer_id INT NOT NULL, CHANGE app_user_id app_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cover_letter ADD CONSTRAINT FK_EBE6B473481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id)');
        $this->addSql('ALTER TABLE cover_letter ADD CONSTRAINT FK_EBE6B474A3353D8 FOREIGN KEY (app_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE job_offer CHANGE app_user_id app_user_id INT NOT NULL, CHANGE title title VARCHAR(180) NOT NULL, CHANGE company company VARCHAR(180) NOT NULL, CHANGE link link VARCHAR(120) DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE salary salary VARCHAR(180) DEFAULT NULL, CHANGE contact_person contact_person VARCHAR(120) DEFAULT NULL, CHANGE contact_email contact_email VARCHAR(120) DEFAULT NULL, CHANGE status status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E4A3353D8 FOREIGN KEY (app_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE linked_in_message ADD CONSTRAINT FK_6ACAC8D64A3353D8 FOREIGN KEY (app_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE first_name first_name VARCHAR(120) NOT NULL, CHANGE last_name last_name VARCHAR(120) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cover_letter DROP FOREIGN KEY FK_EBE6B473481D195');
        $this->addSql('ALTER TABLE cover_letter DROP FOREIGN KEY FK_EBE6B474A3353D8');
        $this->addSql('ALTER TABLE cover_letter CHANGE job_offer_id job_offer_id INT DEFAULT NULL, CHANGE app_user_id app_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E4A3353D8');
        $this->addSql('ALTER TABLE job_offer CHANGE app_user_id app_user_id INT DEFAULT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE company company VARCHAR(150) NOT NULL, CHANGE link link VARCHAR(255) DEFAULT \'NULL\', CHANGE location location VARCHAR(255) DEFAULT \'NULL\', CHANGE salary salary VARCHAR(50) DEFAULT \'NULL\', CHANGE contact_person contact_person VARCHAR(255) DEFAULT \'NULL\', CHANGE contact_email contact_email VARCHAR(255) DEFAULT \'NULL\', CHANGE status status VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE linked_in_message DROP FOREIGN KEY FK_6ACAC8D64A3353D8');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE `user` DROP is_verified, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE first_name first_name VARCHAR(80) NOT NULL, CHANGE last_name last_name VARCHAR(80) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT \'NULL\'');
    }
}
