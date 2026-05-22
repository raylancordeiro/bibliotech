<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subjects')]
final class SubjectController extends AbstractController
{
    #[Route('', name: 'subject_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        SubjectRepository $subjectRepository
    ): Response {

        try {

            $subject = new Subject();

            $form = $this->createForm(SubjectType::class, $subject);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->persist($subject);

                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'subject.flash.created_successfully'
                );

                return $this->redirectToRoute('subject_index');
            }

        } catch (\Exception $exception) {

            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        return $this->render('subject/index.html.twig', [
            'subjects' => $subjectRepository->findAll(),
            'form' => $form,
            'isFormInvalid' => $form->isSubmitted() && !$form->isValid(),
        ]);
    }

    #[Route('/{id}/delete', name: 'subject_delete', methods: ['GET'])]
    public function delete(
        Subject $subject,
        EntityManagerInterface $entityManager
    ): Response {

        try {

            $entityManager->remove($subject);

            $entityManager->flush();

        } catch (\Exception $exception) {

            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        $this->addFlash(
            'success',
            'subject.flash.deleted_successfully'
        );

        return $this->redirectToRoute('subject_index');
    }

    #[Route('/{id}/update', name: 'subject_update', methods: ['POST'])]
    public function update(
        Request $request,
        Subject $subject,
        EntityManagerInterface $entityManager,
        SubjectRepository $subjectRepository
    ): Response {

        $form = $this->createForm(SubjectType::class, $subject);

        try {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'subject.flash.updated_successfully'
                );

                return $this->redirectToRoute('subject_index');
            }

        } catch (\Exception $exception) {

            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }

        return $this->render('subject/index.html.twig', [
            'subjects' => $subjectRepository->findAll(),
            'form' => $form,
            'isFormInvalid' => $form->isSubmitted() && !$form->isValid(),
        ]);
    }
}
