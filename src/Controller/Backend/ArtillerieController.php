<?php

namespace App\Controller\Backend;

use App\Entity\Artillerie;
use App\form\ArtillerieType;
use App\Repository\ArtillerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/artillerie')]
class ArtillerieController extends AbstractController
{
    #[Route('', name: 'app_artillerie_index', methods: ['GET'])]
    public function index(ArtillerieRepository $artillerieRepository): Response
    {
        return $this->render('Backend/Artillerie/index.html.twig', [
            'artillerie' => $artillerieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_artillerie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artillerie = new Artillerie();
        $form = $this->createForm(ArtillerieType::class, $artillerie);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artillerie);
            $entityManager->flush();

            $this->addFlash('success', 'Artillerie ajouter avec succès');

            return $this->redirectToRoute('Artillerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Artillerie/new.html.twig', [
            'artillerie' => $artillerie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}/edit', name: 'app_artillerie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artillerie $artillerie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtillerieType::class, $artillerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Artillerie modifié avec succès');

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Artillerie/edit.html.twig', [
            'artillerie' => $artillerie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artillerie_delete', methods: ['POST'])]
    public function delete(Request $request, Artillerie $artillerie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artillerie->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($artillerie);
            $entityManager->flush();

            $this->addFlash('success', 'Artillerie supprimé avec succès');
        }

        return $this->redirectToRoute('artillerie_index', [], Response::HTTP_SEE_OTHER);
    }
}
