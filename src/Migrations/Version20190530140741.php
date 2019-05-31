<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190530140741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('DROP TABLE contact_organisateur');
        $this->addSql('DROP TABLE organisateur_evenement');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_organisateur (contact_id INT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_67605F70D936B2FA (organisateur_id), INDEX IDX_67605F70E7A1254A (contact_id), PRIMARY KEY(contact_id, organisateur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE organisateur_evenement (organisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_361356ACD936B2FA (organisateur_id), INDEX IDX_361356ACFD02F13 (evenement_id), PRIMARY KEY(organisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contact_organisateur ADD CONSTRAINT FK_67605F70D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_organisateur ADD CONSTRAINT FK_67605F70E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reponse');
    }
}
