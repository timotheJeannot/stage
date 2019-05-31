<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190530193845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_23A0E66FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_evenement (article_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_D113383A7294869C (article_id), INDEX IDX_D113383AFD02F13 (evenement_id), PRIMARY KEY(article_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, satisfaction_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, reponse VARCHAR(255) DEFAULT NULL, INDEX IDX_490F70C6DE9439B8 (satisfaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, site_web VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisateur_contact (organisateur_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_5F84A3B8D936B2FA (organisateur_id), INDEX IDX_5F84A3B8E7A1254A (contact_id), PRIMARY KEY(organisateur_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, lieu_id INT NOT NULL, utilisateur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, published_at DATETIME NOT NULL, domaine VARCHAR(255) NOT NULL, survey TINYINT(1) NOT NULL, INDEX IDX_B26681E6AB213CC (lieu_id), INDEX IDX_B26681EFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_article (evenement_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_13F19BAFD02F13 (evenement_id), INDEX IDX_13F19BA7294869C (article_id), PRIMARY KEY(evenement_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_intervalle_temps (evenement_id INT NOT NULL, intervalle_temps_id INT NOT NULL, INDEX IDX_4822A113FD02F13 (evenement_id), INDEX IDX_4822A1131B824AB9 (intervalle_temps_id), PRIMARY KEY(evenement_id, intervalle_temps_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_organisateur (evenement_id INT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_E7FA0112FD02F13 (evenement_id), INDEX IDX_E7FA0112D936B2FA (organisateur_id), PRIMARY KEY(evenement_id, organisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_inscrit (evenement_id INT NOT NULL, inscrit_id INT NOT NULL, INDEX IDX_917AB4B9FD02F13 (evenement_id), INDEX IDX_917AB4B96DCD4FEE (inscrit_id), PRIMARY KEY(evenement_id, inscrit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_contact (id INT AUTO_INCREMENT NOT NULL, organisateur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_FD587E69D936B2FA (organisateur_id), INDEX IDX_FD587E69FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_contact_contact (liste_contact_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_1BA009D5F54BB8DC (liste_contact_id), INDEX IDX_1BA009D5E7A1254A (contact_id), PRIMARY KEY(liste_contact_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, service VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscrit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_B6F7494EFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervalle_temps (id INT AUTO_INCREMENT NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE satisfaction (id INT AUTO_INCREMENT NOT NULL, inscrit_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, INDEX IDX_8A8E0C136DCD4FEE (inscrit_id), INDEX IDX_8A8E0C13FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE article_evenement ADD CONSTRAINT FK_D113383A7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_evenement ADD CONSTRAINT FK_D113383AFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C6DE9439B8 FOREIGN KEY (satisfaction_id) REFERENCES satisfaction (id)');
        $this->addSql('ALTER TABLE organisateur_contact ADD CONSTRAINT FK_5F84A3B8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisateur_contact ADD CONSTRAINT FK_5F84A3B8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evenement_article ADD CONSTRAINT FK_13F19BAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_article ADD CONSTRAINT FK_13F19BA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_intervalle_temps ADD CONSTRAINT FK_4822A113FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_intervalle_temps ADD CONSTRAINT FK_4822A1131B824AB9 FOREIGN KEY (intervalle_temps_id) REFERENCES intervalle_temps (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_organisateur ADD CONSTRAINT FK_E7FA0112FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_organisateur ADD CONSTRAINT FK_E7FA0112D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_inscrit ADD CONSTRAINT FK_917AB4B9FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_inscrit ADD CONSTRAINT FK_917AB4B96DCD4FEE FOREIGN KEY (inscrit_id) REFERENCES inscrit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_contact ADD CONSTRAINT FK_FD587E69D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id)');
        $this->addSql('ALTER TABLE liste_contact ADD CONSTRAINT FK_FD587E69FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE liste_contact_contact ADD CONSTRAINT FK_1BA009D5F54BB8DC FOREIGN KEY (liste_contact_id) REFERENCES liste_contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_contact_contact ADD CONSTRAINT FK_1BA009D5E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE satisfaction ADD CONSTRAINT FK_8A8E0C136DCD4FEE FOREIGN KEY (inscrit_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE satisfaction ADD CONSTRAINT FK_8A8E0C13FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6AB213CC');
        $this->addSql('ALTER TABLE article_evenement DROP FOREIGN KEY FK_D113383A7294869C');
        $this->addSql('ALTER TABLE evenement_article DROP FOREIGN KEY FK_13F19BA7294869C');
        $this->addSql('ALTER TABLE organisateur_contact DROP FOREIGN KEY FK_5F84A3B8D936B2FA');
        $this->addSql('ALTER TABLE evenement_organisateur DROP FOREIGN KEY FK_E7FA0112D936B2FA');
        $this->addSql('ALTER TABLE liste_contact DROP FOREIGN KEY FK_FD587E69D936B2FA');
        $this->addSql('ALTER TABLE organisateur_contact DROP FOREIGN KEY FK_5F84A3B8E7A1254A');
        $this->addSql('ALTER TABLE liste_contact_contact DROP FOREIGN KEY FK_1BA009D5E7A1254A');
        $this->addSql('ALTER TABLE article_evenement DROP FOREIGN KEY FK_D113383AFD02F13');
        $this->addSql('ALTER TABLE evenement_article DROP FOREIGN KEY FK_13F19BAFD02F13');
        $this->addSql('ALTER TABLE evenement_intervalle_temps DROP FOREIGN KEY FK_4822A113FD02F13');
        $this->addSql('ALTER TABLE evenement_organisateur DROP FOREIGN KEY FK_E7FA0112FD02F13');
        $this->addSql('ALTER TABLE evenement_inscrit DROP FOREIGN KEY FK_917AB4B9FD02F13');
        $this->addSql('ALTER TABLE liste_contact DROP FOREIGN KEY FK_FD587E69FD02F13');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EFD02F13');
        $this->addSql('ALTER TABLE satisfaction DROP FOREIGN KEY FK_8A8E0C13FD02F13');
        $this->addSql('ALTER TABLE liste_contact_contact DROP FOREIGN KEY FK_1BA009D5F54BB8DC');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FB88E14F');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EFB88E14F');
        $this->addSql('ALTER TABLE evenement_inscrit DROP FOREIGN KEY FK_917AB4B96DCD4FEE');
        $this->addSql('ALTER TABLE satisfaction DROP FOREIGN KEY FK_8A8E0C136DCD4FEE');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE evenement_intervalle_temps DROP FOREIGN KEY FK_4822A1131B824AB9');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C6DE9439B8');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_evenement');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE organisateur');
        $this->addSql('DROP TABLE organisateur_contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_article');
        $this->addSql('DROP TABLE evenement_intervalle_temps');
        $this->addSql('DROP TABLE evenement_organisateur');
        $this->addSql('DROP TABLE evenement_inscrit');
        $this->addSql('DROP TABLE liste_contact');
        $this->addSql('DROP TABLE liste_contact_contact');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE inscrit');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE intervalle_temps');
        $this->addSql('DROP TABLE satisfaction');
    }
}
