<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190416135252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article_evenement (article_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_D113383A7294869C (article_id), INDEX IDX_D113383AFD02F13 (evenement_id), PRIMARY KEY(article_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_evenement ADD CONSTRAINT FK_D113383A7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_evenement ADD CONSTRAINT FK_D113383AFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE evenement_intervalle_temps');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evenement_intervalle_temps (evenement_id INT NOT NULL, intervalle_temps_id INT NOT NULL, INDEX IDX_4822A113FD02F13 (evenement_id), INDEX IDX_4822A1131B824AB9 (intervalle_temps_id), PRIMARY KEY(evenement_id, intervalle_temps_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement_intervalle_temps ADD CONSTRAINT FK_4822A1131B824AB9 FOREIGN KEY (intervalle_temps_id) REFERENCES intervalle_temps (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_intervalle_temps ADD CONSTRAINT FK_4822A113FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE article_evenement');
    }
}
