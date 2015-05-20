<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150520113329 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diridarek__Message ADD delFirst_id INT DEFAULT NULL, ADD delSeconde_id INT DEFAULT NULL, DROP del_first, DROP del_seconde');
        $this->addSql('ALTER TABLE diridarek__Message ADD CONSTRAINT FK_B6C1A711720A36B2 FOREIGN KEY (delFirst_id) REFERENCES diridarek__User (id)');
        $this->addSql('ALTER TABLE diridarek__Message ADD CONSTRAINT FK_B6C1A71187F82FED FOREIGN KEY (delSeconde_id) REFERENCES diridarek__User (id)');
        $this->addSql('CREATE INDEX IDX_B6C1A711720A36B2 ON diridarek__Message (delFirst_id)');
        $this->addSql('CREATE INDEX IDX_B6C1A71187F82FED ON diridarek__Message (delSeconde_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diridarek__Message DROP FOREIGN KEY FK_B6C1A711720A36B2');
        $this->addSql('ALTER TABLE diridarek__Message DROP FOREIGN KEY FK_B6C1A71187F82FED');
        $this->addSql('DROP INDEX IDX_B6C1A711720A36B2 ON diridarek__Message');
        $this->addSql('DROP INDEX IDX_B6C1A71187F82FED ON diridarek__Message');
        $this->addSql('ALTER TABLE diridarek__Message ADD del_first VARCHAR(255) DEFAULT NULL, ADD del_seconde VARCHAR(255) DEFAULT NULL, DROP delFirst_id, DROP delSeconde_id');
    }
}
