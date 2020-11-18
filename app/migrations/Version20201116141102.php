<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116141102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, state_department_id INT DEFAULT NULL, locality_name VARCHAR(255) NOT NULL, population INT DEFAULT NULL, coordinate LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', area DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2D5B02349D96F933 (state_department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE climat (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, infos LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE climat_plant (climat_id INT NOT NULL, plant_id INT NOT NULL, INDEX IDX_6A96217177E87C9D (climat_id), INDEX IDX_6A9621711D935652 (plant_id), PRIMARY KEY(climat_id, plant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_project (id INT AUTO_INCREMENT NOT NULL, group_linked_id INT NOT NULL, project_id INT NOT NULL, created_at DATE NOT NULL, end_date DATE DEFAULT NULL, status SMALLINT DEFAULT NULL, INDEX IDX_A9B384E29665CD05 (group_linked_id), INDEX IDX_A9B384E2166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, group_linked_id INT NOT NULL, created_at DATE NOT NULL, end_date DATE DEFAULT NULL, status SMALLINT DEFAULT NULL, INDEX IDX_A4C98D39A76ED395 (user_id), INDEX IDX_A4C98D399665CD05 (group_linked_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, land_lord_id INT DEFAULT NULL, climat_id INT DEFAULT NULL, coordinate LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', reference VARCHAR(255) DEFAULT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_B81291B9E92FFD8 (land_lord_id), INDEX IDX_B81291B77E87C9D (climat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, vernicular VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant_project (plant_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_553A1A971D935652 (plant_id), INDEX IDX_553A1A97166D1F9C (project_id), PRIMARY KEY(plant_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant_group (plant_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_9E1ADD4D1D935652 (plant_id), INDEX IDX_9E1ADD4DFE54D947 (group_id), PRIMARY KEY(plant_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATE NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, visibility TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_lot (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, lot_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, INDEX IDX_99FAF3F8166D1F9C (project_id), INDEX IDX_99FAF3F8A8CBA5F7 (lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6498BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02349D96F933 FOREIGN KEY (state_department_id) REFERENCES state_department (id)');
        $this->addSql('ALTER TABLE climat_plant ADD CONSTRAINT FK_6A96217177E87C9D FOREIGN KEY (climat_id) REFERENCES climat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE climat_plant ADD CONSTRAINT FK_6A9621711D935652 FOREIGN KEY (plant_id) REFERENCES plant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_project ADD CONSTRAINT FK_A9B384E29665CD05 FOREIGN KEY (group_linked_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE group_project ADD CONSTRAINT FK_A9B384E2166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D399665CD05 FOREIGN KEY (group_linked_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B9E92FFD8 FOREIGN KEY (land_lord_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B77E87C9D FOREIGN KEY (climat_id) REFERENCES climat (id)');
        $this->addSql('ALTER TABLE plant_project ADD CONSTRAINT FK_553A1A971D935652 FOREIGN KEY (plant_id) REFERENCES plant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_project ADD CONSTRAINT FK_553A1A97166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_group ADD CONSTRAINT FK_9E1ADD4D1D935652 FOREIGN KEY (plant_id) REFERENCES plant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_group ADD CONSTRAINT FK_9E1ADD4DFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_lot ADD CONSTRAINT FK_99FAF3F8166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_lot ADD CONSTRAINT FK_99FAF3F8A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498BAC62AF');
        $this->addSql('ALTER TABLE climat_plant DROP FOREIGN KEY FK_6A96217177E87C9D');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B77E87C9D');
        $this->addSql('ALTER TABLE group_project DROP FOREIGN KEY FK_A9B384E29665CD05');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D399665CD05');
        $this->addSql('ALTER TABLE plant_group DROP FOREIGN KEY FK_9E1ADD4DFE54D947');
        $this->addSql('ALTER TABLE project_lot DROP FOREIGN KEY FK_99FAF3F8A8CBA5F7');
        $this->addSql('ALTER TABLE climat_plant DROP FOREIGN KEY FK_6A9621711D935652');
        $this->addSql('ALTER TABLE plant_project DROP FOREIGN KEY FK_553A1A971D935652');
        $this->addSql('ALTER TABLE plant_group DROP FOREIGN KEY FK_9E1ADD4D1D935652');
        $this->addSql('ALTER TABLE group_project DROP FOREIGN KEY FK_A9B384E2166D1F9C');
        $this->addSql('ALTER TABLE plant_project DROP FOREIGN KEY FK_553A1A97166D1F9C');
        $this->addSql('ALTER TABLE project_lot DROP FOREIGN KEY FK_99FAF3F8166D1F9C');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02349D96F933');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39A76ED395');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B9E92FFD8');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE climat');
        $this->addSql('DROP TABLE climat_plant');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_project');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE plant');
        $this->addSql('DROP TABLE plant_project');
        $this->addSql('DROP TABLE plant_group');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_lot');
        $this->addSql('DROP TABLE state_department');
        $this->addSql('DROP TABLE user');
    }
}
