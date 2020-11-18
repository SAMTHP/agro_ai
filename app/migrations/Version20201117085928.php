<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117085928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city_plant (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, city_id INT NOT NULL, plant_id INT NOT NULL, year DATE NOT NULL, quantity_sold DOUBLE PRECISION DEFAULT NULL, quantity_produced DOUBLE PRECISION DEFAULT NULL, INDEX IDX_E889AA254EC001D1 (season_id), INDEX IDX_E889AA258BAC62AF (city_id), INDEX IDX_E889AA251D935652 (plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city_plant ADD CONSTRAINT FK_E889AA254EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE city_plant ADD CONSTRAINT FK_E889AA258BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE city_plant ADD CONSTRAINT FK_E889AA251D935652 FOREIGN KEY (plant_id) REFERENCES plant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city_plant DROP FOREIGN KEY FK_E889AA254EC001D1');
        $this->addSql('DROP TABLE city_plant');
        $this->addSql('DROP TABLE season');
    }
}
