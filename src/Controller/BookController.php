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

        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $bookService->create($book);

                $this->addFlash(
                    'success',
                'flash.book_created_successfully'
                );

                return $this->redirectToRoute('book_index');
            }
        } catch (\Exception $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        return $this->render('book/index.html.twig', [
            'books' => $bookService->findAll(),
            'form' => $form->createView(),
            'isFormInvalid' => $form->isSubmitted() && !$form->isValid(),
        ]);
    }

    #[Route('/{id}/delete', name: 'book_delete', methods: ['GET'])]
    public function delete(
        Request $request,
        Book $book,
        EntityManagerInterface $entityManager
    ): Response {

        try {
            $entityManager->remove($book);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }
        $this->addFlash(
            'success',
            'flash.book_deleted_successfully'
        );

        return $this->redirectToRoute('book_index');
    }

    #[Route('/{id}/update', name: 'book_update', methods: ['POST'])]
    public function update(
        Request $request,
        Book $book,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(BookType::class, $book);

        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'flash.book_updated_successfully'
                );

            }
        } catch (\Exception $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        return $this->redirectToRoute('book_index');
    }
}
