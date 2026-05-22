<?php

namespace App\Service\ReportService;

class AuthorReportService extends BaseReportService
{
    public function booksByAuthor(): array
    {
        $rows = $this->reportRepository->booksByAuthor();

        $grouped = [];

        foreach ($rows as $row) {

            $authorName = $row['author_name'];

            if (!isset($grouped[$authorName])) {
                $grouped[$authorName] = [];
            }

            $grouped[$authorName][] = $row;
        }

        return $grouped;
    }
}
