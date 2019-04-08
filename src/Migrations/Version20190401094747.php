<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401094747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE organisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, site_web VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisateur_evenement (organisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_361356ACD936B2FA (organisateur_id), INDEX IDX_361356ACFD02F13 (evenement_id), PRIMARY KEY(organisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisateur_evenement DROP FOREIGN KEY FK_361356ACD936B2FA');
        $this->addSql('DROP TABLE organisateur');
        $this->addSql('DROP TABLE organisateur_evenement');
    }
}
