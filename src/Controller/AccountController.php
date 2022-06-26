<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordUpdateType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('account/{id}', name: 'app_account', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            $this->addFlash(
                'notice',
                'Vos changements ont été enrengistrés '
            );

            return $this->redirectToRoute('app_account', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account/index.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
