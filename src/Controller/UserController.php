<?php

namespace App\Controller;

use App\Entity\Teams;
use App\Form\TeamsType;
use App\Form\UserType;
use App\Manager\TeamManager;
use Doctrine\Common\Lexer\Token;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route("/insert/user", name: "insertUser")]
    public function insertUser(
        EntityManagerInterface $doctrine,
        Request $request,
        UserPasswordHasherInterface $cifrado

    ) {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $user = $form->getData();

            $password = $user->getPassword();
            $passwordCifrado = $cifrado->hashPassword($user, $password);
            $user->setPassword($passwordCifrado);


            $doctrine->persist($user);
            $doctrine->flush();
            return $this->redirectToRoute("listTeams");
        }
        return $this->renderForm('Proyect/insertTeam.html.twig', ['teamsForm' => $form]);
    }
    #[Route("/insert/admin", name: "insertAdmin")]
    public function insertAdmin(
        EntityManagerInterface $doctrine,
        Request $request,
        UserPasswordHasherInterface $cifrado

    ) {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $user = $form->getData();

            $password = $user->getPassword();
            $passwordCifrado = $cifrado->hashPassword($user, $password);
            $user->setPassword($passwordCifrado);
            $user->setRoles(["ROLE_ADMIN", "ROLE_USER"]);

            $doctrine->persist($user);
            $doctrine->flush();
            return $this->redirectToRoute("listTeams");
        }
        return $this->renderForm('Proyect/insertTeam.html.twig', ['teamsForm' => $form]);
    }
}
