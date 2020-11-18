<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117075135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD climat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023477E87C9D FOREIGN KEY (climat_id) REFERENCES climat (id)');
        $this->addSql('CREATE INDEX IDX_2D5B023477E87C9D ON city (climat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023477E87C9D');
        $this->addSql('DROP INDEX IDX_2D5B023477E87C9D ON city');
        $this->addSql('ALTER TABLE city DROP climat_id');
    }
}
