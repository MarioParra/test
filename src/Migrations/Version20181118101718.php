<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181118101718 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE room_type_quantity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_type_id INTEGER DEFAULT NULL, init_date DATE NOT NULL, end_date DATE NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3BBC812C296E3073 ON room_type_quantity (room_type_id)');
        $this->addSql('DROP INDEX IDX_80748372296E3073');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_price AS SELECT id, room_type_id, price FROM room_price');
        $this->addSql('DROP TABLE room_price');
        $this->addSql('CREATE TABLE room_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_type_id INTEGER DEFAULT NULL, price DOUBLE PRECISION NOT NULL, CONSTRAINT FK_80748372296E3073 FOREIGN KEY (room_type_id) REFERENCES room_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room_price (id, room_type_id, price) SELECT id, room_type_id, price FROM __temp__room_price');
        $this->addSql('DROP TABLE __temp__room_price');
        $this->addSql('CREATE INDEX IDX_80748372296E3073 ON room_price (room_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE room_type_quantity');
        $this->addSql('DROP INDEX IDX_80748372296E3073');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_price AS SELECT id, room_type_id, price FROM room_price');
        $this->addSql('DROP TABLE room_price');
        $this->addSql('CREATE TABLE room_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_type_id INTEGER DEFAULT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO room_price (id, room_type_id, price) SELECT id, room_type_id, price FROM __temp__room_price');
        $this->addSql('DROP TABLE __temp__room_price');
        $this->addSql('CREATE INDEX IDX_80748372296E3073 ON room_price (room_type_id)');
    }
}
