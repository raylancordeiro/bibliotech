<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260522174041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create report view';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE VIEW vw_books_by_author_report AS
            SELECT
                a.id AS author_id,
                a.name AS author_name,
                b.id AS book_id,
                b.title AS book_title,
                b.publisher,
                b.edition,
                b.publication_year,
                b.price,
                GROUP_CONCAT(DISTINCT s.description SEPARATOR ', ') AS subjects
            FROM author a
            INNER JOIN book_author ba
                ON ba.author_id = a.id
            INNER JOIN book b
                ON b.id = ba.book_id
            LEFT JOIN book_subject bs
                ON bs.book_id = b.id
            LEFT JOIN subject s
                ON s.id = bs.subject_id
            GROUP BY
                a.id,
                a.name,
                b.id,
                b.title,
                b.publisher,
                b.edition,
                b.publication_year,
                b.price
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP VIEW IF EXISTS vw_books_by_author_report');

    }
}
