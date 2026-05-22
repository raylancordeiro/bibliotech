<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookAuthor;
use App\Entity\BookSubject;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authors = [];

        $authorNames = [
            'Machado de Assis',
            'Clarice Lispector',
            'George Orwell',
            'J. K. Rowling',
            'J. R. R. Tolkien',
        ];

        foreach ($authorNames as $authorName) {

            $author = new Author();

            $author->setName($authorName);

            $manager->persist($author);

            $authors[] = $author;
        }

        $subjects = [];

        $subjectDescriptions = [
            'Romance',
            'Fantasia',
            'Ficção Científica',
            'Drama',
            'Aventura',
        ];

        foreach ($subjectDescriptions as $subjectDescription) {

            $subject = new Subject();

            $subject->setDescription($subjectDescription);

            $manager->persist($subject);

            $subjects[] = $subject;
        }

        $booksData = [
            [
                'title' => 'Dom Casmurro',
                'publisher' => 'Editora A',
                'edition' => '1ª',
                'publicationYear' => 1899,
                'price' => '39.90',
                'authors' => [0],
                'subjects' => [0, 3],
            ],
            [
                'title' => '1984',
                'publisher' => 'Editora B',
                'edition' => '2ª',
                'publicationYear' => 1949,
                'price' => '49.90',
                'authors' => [2],
                'subjects' => [2, 3],
            ],
            [
                'title' => 'Harry Potter',
                'publisher' => 'Editora C',
                'edition' => '1ª',
                'publicationYear' => 1997,
                'price' => '59.90',
                'authors' => [3],
                'subjects' => [1, 4],
            ],
        ];

        foreach ($booksData as $bookData) {

            $book = new Book();

            $book
                ->setTitle($bookData['title'])
                ->setPublisher($bookData['publisher'])
                ->setEdition($bookData['edition'])
                ->setPublicationYear($bookData['publicationYear'])
                ->setPrice($bookData['price']);

            $manager->persist($book);

            foreach ($bookData['authors'] as $authorIndex) {

                $bookAuthor = new BookAuthor();

                $bookAuthor
                    ->setBook($book)
                    ->setAuthor($authors[$authorIndex]);

                $manager->persist($bookAuthor);
            }

            foreach ($bookData['subjects'] as $subjectIndex) {

                $bookSubject = new BookSubject();

                $bookSubject
                    ->setBook($book)
                    ->setSubject($subjects[$subjectIndex]);

                $manager->persist($bookSubject);
            }
        }

        $manager->flush();
    }
}
