<?php

namespace App\Controller;

use App\Service\ReportService\AuthorReportService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reports')]
class ReportController extends AbstractController
{
    #[Route('/books-by-author', name: 'report_books_by_author', methods: ['GET'])]
    public function index(
        AuthorReportService $authorReportService
    ): Response {

        return $this->render(
            'report/books_by_author.html.twig',
            [
                'report' => $authorReportService->booksByAuthor(),
            ]
        );
    }

    #[Route('/books-by-author/pdf', name: 'report_books_by_author_pdf', methods: ['GET'])]
    public function booksByAuthorPdf(
        AuthorReportService $reportService
    ): Response {

        $css = file_get_contents(
            $this->getParameter('kernel.project_dir')
            . '/assets/styles/report-pdf.css'
        );

        $html = $this->renderView(
            'report/pdf/books_by_author.html.twig',
            [
                'report' => $reportService->booksByAuthor(),
                'css' => $css,
            ]
        );

        $options = new Options();

        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return new Response(
            $dompdf->stream(
                'books-by-author-report.pdf',
                [
                    'Attachment' => false,
                ]
            ),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}
