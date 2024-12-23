<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241223155800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, credits_id INT DEFAULT NULL, trajets_id INT DEFAULT NULL, tajetsedit_id INT DEFAULT NULL, trajetsfini_id INT DEFAULT NULL, avis_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', api_token VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64923DEF1B2 (credits_id), INDEX IDX_8D93D649451BDEFF (trajets_id), INDEX IDX_8D93D6496F7F650E (tajetsedit_id), INDEX IDX_8D93D6497FB3E3D9 (trajetsfini_id), UNIQUE INDEX UNIQ_8D93D649197E709F (avis_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64923DEF1B2 FOREIGN KEY (credits_id) REFERENCES credits (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649451BDEFF FOREIGN KEY (trajets_id) REFERENCES trajets (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496F7F650E FOREIGN KEY (tajetsedit_id) REFERENCES trajetsedit (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497FB3E3D9 FOREIGN KEY (trajetsfini_id) REFERENCES trajetsfini (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649197E709F FOREIGN KEY (avis_id) REFERENCES avis (id)');
        $this->addSql('ALTER TABLE voiture ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FA76ED395 ON voiture (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64923DEF1B2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649451BDEFF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496F7F650E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497FB3E3D9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649197E709F');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_E9E2810FA76ED395 ON voiture');
        $this->addSql('ALTER TABLE voiture DROP user_id');
    }
}
