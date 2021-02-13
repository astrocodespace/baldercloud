<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212231545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE balder_collections (
                collection VARCHAR(64) PRIMARY KEY NOT NULL,
                managed BOOLEAN DEFAULT TRUE NOT NULL,
                icon VARCHAR(255) DEFAULT NULL,
                note VARCHAR(255) DEFAULT NULL
            )
        ');

        $this->addSql('
            CREATE TABLE balder_
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
