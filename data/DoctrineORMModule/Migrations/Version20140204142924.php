<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140204142924 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE z2t_user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, pass_hash VARCHAR(40) NOT NULL, full_name VARCHAR(255) NOT NULL, info_xml LONGTEXT NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME NOT NULL, last_login DATETIME NOT NULL, UNIQUE INDEX UNIQ_E169F8D2AA08CB10 (login), UNIQUE INDEX UNIQ_E169F8D2E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE z2t_dashboard_messages (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, status SMALLINT NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE album");
        $this->addSql("DROP TABLE general_log");
        $this->addSql("DROP TABLE slow_log");
        $this->addSql("ALTER TABLE z2t_admin CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE login login VARCHAR(100) NOT NULL, CHANGE email email VARCHAR(150) NOT NULL, CHANGE full_name full_name VARCHAR(255) NOT NULL, CHANGE created create_at DATETIME NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_EFBFBD94AA08CB10 ON z2t_admin (login)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_EFBFBD94E7927C74 ON z2t_admin (email)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE album (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(100) DEFAULT NULL, artist VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE general_log (event_time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, user_host LONGTEXT NOT NULL, thread_id BIGINT UNSIGNED NOT NULL, server_id INT UNSIGNED NOT NULL, command_type VARCHAR(64) NOT NULL, argument LONGTEXT NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE slow_log (start_time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, user_host LONGTEXT NOT NULL, query_time TIME NOT NULL, lock_time TIME NOT NULL, rows_sent INT NOT NULL, rows_examined INT NOT NULL, db VARCHAR(512) NOT NULL, last_insert_id INT NOT NULL, insert_id INT NOT NULL, server_id INT UNSIGNED NOT NULL, sql_text LONGTEXT NOT NULL, thread_id BIGINT UNSIGNED NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE z2t_user");
        $this->addSql("DROP TABLE z2t_dashboard_messages");
        $this->addSql("DROP INDEX UNIQ_EFBFBD94AA08CB10 ON z2t_admin");
        $this->addSql("DROP INDEX UNIQ_EFBFBD94E7927C74 ON z2t_admin");
        $this->addSql("ALTER TABLE z2t_admin CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE login login VARCHAR(30) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE full_name full_name VARCHAR(150) NOT NULL, CHANGE create_at created DATETIME NOT NULL");
    }
}
