<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241029180906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, breed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birthdate DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, is_published TINYINT(1) NOT NULL, price_ht DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, INDEX IDX_6AAB231FC54C8C93 (type_id), INDEX IDX_6AAB231FA8B4A30F (breed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breed (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, sort_number INT DEFAULT NULL, INDEX IDX_8F7C2FC08E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC08E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FC54C8C93');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FA8B4A30F');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC08E962C16');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE breed');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE type');
    }
}
