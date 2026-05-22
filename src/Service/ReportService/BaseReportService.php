<?php

namespace App\Service\ReportService;

use App\Repository\ReportRepository;
use Doctrine\DBAL\Connection;

abstract class BaseReportService
{
    public function __construct(
        protected Connection $connection,
        protected ReportRepository $reportRepository
    ) {
    }
}
