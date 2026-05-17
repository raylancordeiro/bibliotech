<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Service\BookService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/books')]
class BookController extends AbstractController
{
    #[Route('', name: 'book_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        BookService $bookService
    ): Response {
        $book = new Book();

        $form = $this->createForm(
            BookType::class,
            $book
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookService->create($book);

            $this->addFlash(
                'success',
                'Book created successfully.'
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/index.html.twig', [
            'books' => $bookService->findAll(),
            'form' => $form->createView(),
            'isFormInvalid' => $form->isSubmitted() && !$form->isValid(),
        ]);
    }

    #[Route('/create', name: 'book_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Book created successfully.'
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/create.html.twig', [
            'form' => $form,
        ]);
    }
}
