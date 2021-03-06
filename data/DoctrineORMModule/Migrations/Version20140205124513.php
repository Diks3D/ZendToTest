<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140205124513 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE z2t_money_accounts (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, remote_identy VARCHAR(255) NOT NULL, token_storage LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', create_at DATETIME NOT NULL, update_at DATETIME NOT NULL, account_type VARCHAR(255) NOT NULL, INDEX IDX_7A6769BEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE z2t_money_accounts ADD CONSTRAINT FK_7A6769BEA76ED395 FOREIGN KEY (user_id) REFERENCES z2t_user (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE z2t_money_accounts");
    }
}
