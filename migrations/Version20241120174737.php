<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241120174737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates products table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE products (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(55) NOT NULL, quantity INTEGER NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE products');
    }
}
