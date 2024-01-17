<?php

declare(strict_types=1);

namespace App\InfrastructureLayer\Postgres\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227071852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT fk_profile');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT fk_address');
        $this->addSql('ALTER TABLE users ADD previous_version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER profile_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER address_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER token TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER confirm DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER confirm SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE address ALTER id TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE users DROP previous_version');
        $this->addSql('ALTER TABLE users ALTER id TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE users ALTER address_id TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE users ALTER profile_id TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE users ALTER token TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE users ALTER confirm SET DEFAULT false');
        $this->addSql('ALTER TABLE users ALTER confirm DROP NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT fk_profile FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT fk_address FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E9CCFA12B8 ON users (profile_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9F5B7AF75 ON users (address_id)');
        $this->addSql('ALTER TABLE profile ALTER id TYPE VARCHAR(250)');
    }
}
