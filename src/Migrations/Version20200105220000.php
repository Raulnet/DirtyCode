<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105220000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE member (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
          name VARCHAR(255) NOT NULL, 
          username VARCHAR(255) NOT NULL, 
          email VARCHAR(255) NOT NULL, 
          phone VARCHAR(255) DEFAULT NULL, 
          website VARCHAR(255) DEFAULT NULL, 
          agency_id INTEGER NOT NULL
        )');
        $this->addSql('CREATE TABLE user (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
          username VARCHAR(180) NOT NULL, 
          roles CLOB NOT NULL --(DC2Type:json)
          , 
          password VARCHAR(255) NOT NULL
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE TABLE agency (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          description CLOB NOT NULL, 
          user_id INTEGER DEFAULT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE agency');
    }
}
