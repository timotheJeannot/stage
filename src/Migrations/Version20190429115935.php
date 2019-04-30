<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429115935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE liste_contact (id INT AUTO_INCREMENT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_FD587E69D936B2FA (organisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_contact_contact (liste_contact_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_1BA009D5F54BB8DC (liste_contact_id), INDEX IDX_1BA009D5E7A1254A (contact_id), PRIMARY KEY(liste_contact_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_contact ADD CONSTRAINT FK_FD587E69D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id)');
        $this->addSql('ALTER TABLE liste_contact_contact ADD CONSTRAINT FK_1BA009D5F54BB8DC FOREIGN KEY (liste_contact_id) REFERENCES liste_contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_contact_contact ADD CONSTRAINT FK_1BA009D5E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE liste_contact_contact DROP FOREIGN KEY FK_1BA009D5F54BB8DC');
        $this->addSql('DROP TABLE liste_contact');
        $this->addSql('DROP TABLE liste_contact_contact');
    }
}
