<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/authors')]
final class AuthorController extends AbstractController
{
    #[Route('', name: 'author_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        AuthorRepository $authorRepository
    ): Response {

        try {
            $author = new Author();

            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->persist($author);
                $entityManager->flush();

                $this->addFlash('success', 'author.flash.created_successfully');
                return $this->redirectToRoute('author_index');
            }
        } catch (\Exception $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        return $this->render('author/index.html.twig', [
            'authors' => $authorRepository->findAll(),
            'form' => $form,
            'isFormInvalid' => $form->isSubmitted() && !$form->isValid(),
        ]);
    }

    #[Route('/{id}/delete', name: 'author_delete', methods: ['GET'])]
    public function delete(
        Author                 $author,
        EntityManagerInterface $entityManager
    ): Response {
        try {
            $entityManager->remove($author);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }
        $this->addFlash(
            'success',
            'author.flash.deleted_successfully'
        );

        return $this->redirectToRoute('author_index');
    }

    #[Route('/{id}/update', name: 'author_update', methods: ['POST'])]
    public function update(
        Request $request,
        Author $author,
        EntityManagerInterface $entityManager,
        AuthorRepository $authorRepository
    ): Response {

        $form = $this->createForm(AuthorType::class, $author);

        try {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'author.flash.updated_successfully'
                );

                return $this->redirectToRoute('author_index');
            }

        } catch (\Exception $exception) {

            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        return $this->render('author/index.html.twig', [
            'authors' => $authorRepository->findAll(),
            'form' => $form,
            'isFormInvalid' => $form->isSubmitted() && !$form->isValid(),
        ]);
    }
}
