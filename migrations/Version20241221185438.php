<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221185438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trajetsfini (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, voiture VARCHAR(255) NOT NULL, dateimat DATETIME NOT NULL, fumeur VARCHAR(255) NOT NULL, annimaux VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, place INT NOT NULL, modele VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, passager1 VARCHAR(255) DEFAULT NULL, passager2 VARCHAR(255) DEFAULT NULL, passager3 VARCHAR(255) DEFAULT NULL, passager4 VARCHAR(255) DEFAULT NULL, passager5 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trajetsfini');
    }
}
