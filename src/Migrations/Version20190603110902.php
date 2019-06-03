<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190603110902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accueil (id INT AUTO_INCREMENT NOT NULL, partenaires_id INT DEFAULT NULL, info_site_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2994CBE38898CF5 (partenaires_id), UNIQUE INDEX UNIQ_2994CBE74783FD8 (info_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE38898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaires (id)');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE74783FD8 FOREIGN KEY (info_site_id) REFERENCES info_site (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE accueil');
    }
}
