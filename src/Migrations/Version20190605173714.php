<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190605173714 extends AbstractMigration
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
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, partenaires_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, site_web VARCHAR(255) NOT NULL, INDEX IDX_32FFA37338898CF5 (partenaires_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaires (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_site (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE38898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaires (id)');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE74783FD8 FOREIGN KEY (info_site_id) REFERENCES info_site (id)');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA37338898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaires (id)');
        $this->addSql('DROP TABLE contact_organisateur');
        $this->addSql('DROP TABLE organisateur_evenement');
        $this->addSql('ALTER TABLE article ADD brouillon TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE part CHANGE reponse reponse LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD brouillon TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE inscrit ADD random_number INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accueil DROP FOREIGN KEY FK_2994CBE38898CF5');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA37338898CF5');
        $this->addSql('ALTER TABLE accueil DROP FOREIGN KEY FK_2994CBE74783FD8');
        $this->addSql('CREATE TABLE contact_organisateur (contact_id INT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_67605F70E7A1254A (contact_id), INDEX IDX_67605F70D936B2FA (organisateur_id), PRIMARY KEY(contact_id, organisateur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE organisateur_evenement (organisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_361356ACFD02F13 (evenement_id), INDEX IDX_361356ACD936B2FA (organisateur_id), PRIMARY KEY(organisateur_id, evenement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contact_organisateur ADD CONSTRAINT FK_67605F70D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_organisateur ADD CONSTRAINT FK_67605F70E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_evenement ADD CONSTRAINT FK_361356ACFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE partenaires');
        $this->addSql('DROP TABLE info_site');
        $this->addSql('ALTER TABLE article DROP brouillon');
        $this->addSql('ALTER TABLE evenement DROP brouillon');
        $this->addSql('ALTER TABLE inscrit DROP random_number');
        $this->addSql('ALTER TABLE part CHANGE reponse reponse VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
