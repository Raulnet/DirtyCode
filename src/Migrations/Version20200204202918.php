<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200204202918 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE transation (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
          serial_number VARCHAR(255) NOT NULL, 
          shop_id INTEGER DEFAULT NULL
        )');
        $this->addSql('CREATE TABLE shop (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          user_id INTEGER DEFAULT NULL
        )');
        $this->addSql('CREATE TABLE product (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          price INTEGER NOT NULL, 
          shop_id INTEGER DEFAULT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE transation');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE product');
    }
}
