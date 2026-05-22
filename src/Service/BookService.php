<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\BookAuthor;
use App\Entity\BookSubject;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BookRepository $bookRepository
    ) {
    }

    public function create(
        Book $book,
        array $authors = [],
        array $subjects = []
    ): void {

        foreach ($authors as $author) {

            $bookAuthor = new BookAuthor();

            $bookAuthor->setAuthor($author);

            $book->addBookAuthor($bookAuthor);
        }

        foreach ($subjects as $subject) {

            $bookSubject = new BookSubject();

            $bookSubject->setSubject($subject);

            $book->addBookSubject($bookSubject);
        }

        $this->entityManager->persist($book);

        $this->entityManager->flush();
    }

    public function update(
        Book $book,
        array $authors = [],
        array $subjects = []
    ): void {

        foreach ($book->getBookAuthors() as $bookAuthor) {
            $book->removeBookAuthor($bookAuthor);
        }

        foreach ($book->getBookSubjects() as $bookSubject) {
            $book->removeBookSubject($bookSubject);
        }

        foreach ($authors as $author) {

            $bookAuthor = new BookAuthor();

            $bookAuthor->setAuthor($author);

            $book->addBookAuthor($bookAuthor);
        }

        foreach ($subjects as $subject) {

            $bookSubject = new BookSubject();

            $bookSubject->setSubject($subject);

            $book->addBookSubject($bookSubject);
        }

        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->bookRepository->findAll();
    }
}
