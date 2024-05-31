<?php

namespace App\Controller\Security;

use App\Entity\Joueur;
use App\Form\JoueurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    #[Route('/login', name: 'app.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authUtils): Response
    {

        return $this->render('login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'lastUsername' => $authUtils->getLastUsername(),
        ]);
    }

    #[Route('/register', name: 'app.register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $joueur = new Joueur();

        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $joueur->setPassword(
                $this->hasher->hashPassword($joueur, $form->get('password')->getData())
            );

            $em->persist($joueur);
            $em->flush();

            $this->addFlash('success', 'Votre compte a bien été créé');

            return $this->redirectToRoute('app.login');
        }

        return $this->render('register.html.twig', [
            'form' => $form
        ]);
    }
}
