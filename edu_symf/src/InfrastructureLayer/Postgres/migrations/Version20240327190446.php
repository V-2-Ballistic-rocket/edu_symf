<?php

declare(strict_types=1);

namespace App\InfrastructureLayer\Postgres\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327190446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD previous_version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users RENAME COLUMN editdate TO edit_date');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP previous_version');
        $this->addSql('ALTER TABLE users RENAME COLUMN edit_date TO editdate');

    }
}
