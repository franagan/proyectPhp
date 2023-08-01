<?php

namespace App\Controller;

use App\Entity\Teams;
use App\Form\TeamsType;
use App\Manager\TeamManager;
use Doctrine\Common\Lexer\Token;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProyectController extends AbstractController
{
    #[Route("/", name: "home")]

    public function home()
    {
        return $this->render("proyect/baseTeams.html.twig");
    }

    #[Route("/equipo/{id}", name: "getTeam")]
    public function getTeam(EntityManagerInterface $doctrine, $id)
    {
        $repository = $doctrine->getRepository(Teams::class);

        $team = $repository->find($id);

        return $this->render("Proyect/team.html.twig", ["team" => $team]);
    }
    #[Route("/equipos", name: "listTeams")]

    public function listTeams(EntityManagerInterface $doctrine)
    {
        $repository = $doctrine->getRepository(Teams::class);

        $teams = $repository->findAll();
        return $this->render("Proyect/listTeams.html.twig", ["listTeams" => $teams]);
    }

    #[Route("/insert/equipo", name: "insertTeam")]
    #[IsGranted("ROLE_ADMIN")]
    public function insertTeam(
        EntityManagerInterface $doctrine,
        Request $request,
        TeamManager $manager
    ) {
        $form = $this->createForm(TeamsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $team = $form->getData();

            $teamImg = $form->get('teamImg')->getData();
            if ($teamImg) {

                $imageUrl = $manager->uploadImage($teamImg, $this->getParameter('kernel.project_dir') . '/public/images');

                $team->setImage($imageUrl);
            }
            $doctrine->persist($team);
            $doctrine->flush();
            return $this->redirectToRoute("listTeams");
        }
        return $this->renderForm('Proyect/insertTeam.html.twig', ['teamsForm' => $form]);
    }

    #[Route("/edit/equipo/{id}", name: "editTeam")]
    #[IsGranted("ROLE_ADMIN")]
    public function editTeam(EntityManagerInterface $doctrine, Request $request, $id)
    {
        $repository = $doctrine->getRepository(Teams::class);
        $team = $repository->find($id);

        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $team = $form->getData();

            $doctrine->persist($team);
            $doctrine->flush();
            return $this->redirectToRoute('listTeams');
        }
        return $this->renderForm('Proyect/insertTeam.html.twig', ['teamsForm' => $form]);
    }


    #[Route("/new/teams")]
    public function newTeam(EntityManagerInterface $doctrine)
    {
        $team1 = new Teams();
        $team1->setName("Fc. Barcelona");
        $team1->setDescription("equipo de primera division de la ciudad de Barcelona");
        $team1->setImg("https://yt3.googleusercontent.com/_ljwi6yw1QgqIAnrkNmD-MSN2uAGSy9CJiV0YhSTLAxqqyoVq3ypKjx3I8pKVDI2b2TKOwkX=s900-c-k-c0x00ffffff-no-rj");
        $team1->setCode("001");

        $team2 = new Teams();
        $team2->setName("Real Madrid");
        $team2->setDescription("equipo de primera division de la ciudad de Madrid");
        $team2->setImg("https://yt3.googleusercontent.com/_ljwi6yw1QgqIAnrkNmD-MSN2uAGSy9CJiV0YhSTLAxqqyoVq3ypKjx3I8pKVDI2b2TKOwkX=s900-c-k-c0x00ffffff-no-rj");
        $team2->setCode("002");

        $team3 = new Teams();
        $team3->setName("Atletico de Madrid");
        $team3->setDescription("equipo de primera division de la ciudad de Madrid");
        $team3->setImg("https://yt3.googleusercontent.com/_ljwi6yw1QgqIAnrkNmD-MSN2uAGSy9CJiV0YhSTLAxqqyoVq3ypKjx3I8pKVDI2b2TKOwkX=s900-c-k-c0x00ffffff-no-rj");
        $team3->setCode("003");

        $team4 = new Teams();
        $team4->setName("Valencia Fc.");
        $team4->setDescription("equipo de primera division de la ciudad de Valencia");
        $team4->setImg("https://yt3.googleusercontent.com/_ljwi6yw1QgqIAnrkNmD-MSN2uAGSy9CJiV0YhSTLAxqqyoVq3ypKjx3I8pKVDI2b2TKOwkX=s900-c-k-c0x00ffffff-no-rj");
        $team4->setCode("004");

        $team5 = new Teams();
        $team5->setName("Sevilla Fc.");
        $team5->setDescription("equipo de primera division de la ciudad de Sevilla");
        $team5->setImg("https://yt3.googleusercontent.com/_ljwi6yw1QgqIAnrkNmD-MSN2uAGSy9CJiV0YhSTLAxqqyoVq3ypKjx3I8pKVDI2b2TKOwkX=s900-c-k-c0x00ffffff-no-rj");
        $team5->setCode("005");

        $team6 = new Teams();
        $team6->setName("Real Betis");
        $team6->setDescription("equipo de primera division de la ciudad de Sevilla");
        $team6->setImg("https://yt3.googleusercontent.com/_ljwi6yw1QgqIAnrkNmD-MSN2uAGSy9CJiV0YhSTLAxqqyoVq3ypKjx3I8pKVDI2b2TKOwkX=s900-c-k-c0x00ffffff-no-rj");
        $team6->setCode("006");

        // $division1 = new Division();
        // $division1->setName("Primera Division");

        // $division2 = new Division();
        // $division2->setName("Uefa");

        // $division3 = new Division();
        // $division3->setName("Champions League");

        // $division4 = new Division();
        // $division4->setName("Copa del Rey");

        // $team1 = addDivisione($division1);



        $doctrine->persist($team1);
        $doctrine->persist($team2);
        $doctrine->persist($team3);
        $doctrine->persist($team4);
        $doctrine->persist($team5);
        $doctrine->persist($team6);
        // $doctrine->persist($division1);
        // $doctrine->persist($division2);
        // $doctrine->persist($division3);
        // $doctrine->persist($division4);


        $doctrine->flush();

        return new Response("Equipos insertados bien");
    }
}
