<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171213224636 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE carts (id INTEGER NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE carts_items (cart_id INTEGER NOT NULL, item_id INTEGER NOT NULL, PRIMARY KEY(cart_id, item_id))');
        $this->addSql('CREATE INDEX IDX_6DBF34661AD5CDBF ON carts_items (cart_id)');
        $this->addSql('CREATE INDEX IDX_6DBF3466126F525E ON carts_items (item_id)');
        $this->addSql('CREATE TABLE items (id INTEGER NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, image VARCHAR(2048) NOT NULL, description TEXT NOT NULL, price NUMERIC(65, 2) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE carts');
        $this->addSql('DROP TABLE carts_items');
        $this->addSql('DROP TABLE items');
    }
}
