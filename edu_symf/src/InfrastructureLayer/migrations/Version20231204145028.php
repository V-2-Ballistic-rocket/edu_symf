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

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE address (id UUID NOT NULL, country VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, street VARCHAR(150) NOT NULL, house_number VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN address.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE profile (id UUID NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, age INTEGER NOT NULL, to_avatar_path VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN profile.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE users (
            id UUID NOT NULL,
            login VARCHAR(30) NOT NULL,
            password VARCHAR(30) NOT NULL,
            email VARCHAR(250) NOT NULL,
            phone_number VARCHAR(15) DEFAULT NULL,
            profile_id UUID,
            address_id UUID,
            token UUID,
            confirm BOOLEAN DEFAULT FALSE,
            CONSTRAINT FK_profile FOREIGN KEY (profile_id) REFERENCES profile (id),
            CONSTRAINT FK_address FOREIGN KEY (address_id) REFERENCES address (id),
            PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.token IS \'(DC2Type:uuid)\'');
    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE users');
    }
}
