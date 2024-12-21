<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221195233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajets ADD voiture_id INT NOT NULL');
        $this->addSql('ALTER TABLE trajets ADD CONSTRAINT FK_FF2B5BA9181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF2B5BA9181A8BA ON trajets (voiture_id)');
        $this->addSql('ALTER TABLE trajetsedit ADD voiture_id INT NOT NULL');
        $this->addSql('ALTER TABLE trajetsedit ADD CONSTRAINT FK_8ACD5B20181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8ACD5B20181A8BA ON trajetsedit (voiture_id)');
        $this->addSql('ALTER TABLE trajetsfini ADD voiture_id INT NOT NULL');
        $this->addSql('ALTER TABLE trajetsfini ADD CONSTRAINT FK_BCE79D83181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BCE79D83181A8BA ON trajetsfini (voiture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajets DROP FOREIGN KEY FK_FF2B5BA9181A8BA');
        $this->addSql('DROP INDEX UNIQ_FF2B5BA9181A8BA ON trajets');
        $this->addSql('ALTER TABLE trajets DROP voiture_id');
        $this->addSql('ALTER TABLE trajetsedit DROP FOREIGN KEY FK_8ACD5B20181A8BA');
        $this->addSql('DROP INDEX UNIQ_8ACD5B20181A8BA ON trajetsedit');
        $this->addSql('ALTER TABLE trajetsedit DROP voiture_id');
        $this->addSql('ALTER TABLE trajetsfini DROP FOREIGN KEY FK_BCE79D83181A8BA');
        $this->addSql('DROP INDEX UNIQ_BCE79D83181A8BA ON trajetsfini');
        $this->addSql('ALTER TABLE trajetsfini DROP voiture_id');
    }
}
