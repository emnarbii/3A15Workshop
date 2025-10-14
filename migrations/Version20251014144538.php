<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014144538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author DROP nb_books');
        $this->addSql('ALTER TABLE book ADD pub_date DATE DEFAULT NULL, CHANGE author_id author_id INT NOT NULL, CHANGE published published TINYINT(1) DEFAULT NULL, CHANGE titre title VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD nb_books INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book DROP pub_date, CHANGE author_id author_id INT DEFAULT NULL, CHANGE published published TINYINT(1) NOT NULL, CHANGE title titre VARCHAR(50) NOT NULL');
    }
}
