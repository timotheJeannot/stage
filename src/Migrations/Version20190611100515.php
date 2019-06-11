<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611100515 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contact_organisateur');
        $this->addSql('DROP TABLE evenement_article');
        $this->addSql('DROP TABLE organisateur_evenement');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_organisateur (contact_id INT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_67605F70D936B2FA (organisateur_id), INDEX IDX_67605F70E7A1254A (contact_id), PRIMARY KEY(contact_id, organisateur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement_article (evenement_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_13F19BA7294869C (article_id), INDEX IDX_13F19BAFD02F13 (evenement_id), PRIMARY KEY(evenement_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE organisateur_evenement (organisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_361356ACD936B2FA (organisateur_id), INDEX IDX_361356ACFD02F13 (evenement_id), PRIMARY KEY(organisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contact_organisateur ADD CONSTRAINT FK_67605F70D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_organisateur ADD CONSTRAINT FK_67605F70E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_article ADD CONSTRAINT FK_13F19BA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_article ADD CONSTRAINT FK_13F19BAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
    }
}
