<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321224418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE unknown (id INT AUTO_INCREMENT NOT NULL, term VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, counter INT NOT NULL, UNIQUE INDEX UNIQ_AD26A7C7A50FE78D (term), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE INDEX description_idx ON ingredient (description)');
        $this->addSql('ALTER TABLE recipe ADD source VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE INDEX name_idx ON recipe (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE unknown');
        $this->addSql('DROP INDEX description_idx ON ingredient');
        $this->addSql('DROP INDEX name_idx ON recipe');
        $this->addSql('ALTER TABLE recipe DROP source');
    }
}
