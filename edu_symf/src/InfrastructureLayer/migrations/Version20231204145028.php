<?php

declare(strict_types=1);

namespace App\InfrastructureLayer\migrations;


use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204145028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
