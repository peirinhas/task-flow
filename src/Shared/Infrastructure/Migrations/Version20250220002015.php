<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250220002015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migrations to generate initial database schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE core_task (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_db_type)\', creator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_db_type)\', priority VARCHAR(30) NOT NULL COMMENT \'(DC2Type:task_priority_db_type)\', status VARCHAR(30) NOT NULL COMMENT \'(DC2Type:task_status_db_type)\', title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE core_user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_db_type)\', name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_BF76157CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metric_task (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_db_type)\', creator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_db_type)\', status VARCHAR(30) NOT NULL, num_updates INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE core_task');
        $this->addSql('DROP TABLE core_user');
        $this->addSql('DROP TABLE metric_task');
    }
}
