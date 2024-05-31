<?php

namespace App\Controller\Backend;

use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/joueur', name: 'admin.joueur')]
class JoueurController extends AbstractController
{
    public function __construct(
        private readonly JoueurRepository $joueurRepo,
        private readonly EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Joueur/index.html.twig', [
            'joueur' => $this->joueurRepo->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Joueur $joueur, Request $request): Response|RedirectResponse
    {
        if (!$joueur) {
            $this->addFlash('danger', 'Utilisateur introuvable.');

            return $this->redirectToRoute('admin.joueur.index');
        }

        $form = $this->createForm(JoueurType::class, $joueur, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($joueur);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur modifié.');

            return $this->redirectToRoute('admin.users.index');
        }

        return $this->render('Backend/Joueur/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Joueur $joueur, Request $request): RedirectResponse
    {
        if (!$joueur) {
            $this->addFlash('danger', 'joueur introuvable.');

            return $this->redirectToRoute('admin.joueur.index');
        }

        if ($this->isCsrfTokenValid('delete' . $joueur->getId(), $request->request->get('token'))) {
            $this->em->remove($joueur);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur supprimé');
        } else {
            $this->addFlash('danger', 'Token CSRF invalide.');
        }
        return $this->redirectToRoute('admin.joueur.index');
    }
}
