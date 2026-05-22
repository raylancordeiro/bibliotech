<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class ReportRepository
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function booksByAuthor(): array
    {
        $sql = '
            SELECT *
            FROM vw_books_by_author_report
            ORDER BY author_name, book_title
        ';

        return $this->connection->fetchAllAssociative($sql);
    }
}
