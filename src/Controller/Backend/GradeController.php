<?php

namespace App\Controller\Backend;

use App\Entity\Grade;
use App\Form\GradeType;
use App\Entity\Artillerie;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/Grade')]
class GradeController extends AbstractController
{
    #[Route('', name: 'app_Grade_index', methods: ['GET'])]
    public function index(GradeRepository $GradeRepository): Response
    {
        return $this->render('Backend/Grade/index.html.twig', [
            'Grade' => $GradeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_Grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grade);
            $entityManager->flush();

            $this->addFlash('success', 'Grade ajouter avec succès');
        }
        return $this->render('Backend/Grade/new.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{code}/edit', name: 'app_Grade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grade $grade, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Grade modifié avec succès');

            return $this->redirectToRoute('admin.grade.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Grade/edit.html.twig', [
            'Grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grade_delete', methods: ['POST'])]
    public function delete(Request $request, Grade $grade, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $grade->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($grade);
            $entityManager->flush();

            $this->addFlash('success', 'Grade supprimé avec succès');
        }

        return $this->redirectToRoute('admin.artillerie.index', [], Response::HTTP_SEE_OTHER);
    }
}