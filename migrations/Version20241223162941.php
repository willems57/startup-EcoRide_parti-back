<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241223162941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trajetsfini_user (trajetsfini_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8D0772F87FB3E3D9 (trajetsfini_id), INDEX IDX_8D0772F8A76ED395 (user_id), PRIMARY KEY(trajetsfini_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajetsfini_user ADD CONSTRAINT FK_8D0772F87FB3E3D9 FOREIGN KEY (trajetsfini_id) REFERENCES trajetsfini (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajetsfini_user ADD CONSTRAINT FK_8D0772F8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajetsfini_user DROP FOREIGN KEY FK_8D0772F87FB3E3D9');
        $this->addSql('ALTER TABLE trajetsfini_user DROP FOREIGN KEY FK_8D0772F8A76ED395');
        $this->addSql('DROP TABLE trajetsfini_user');
    }
}
