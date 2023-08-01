<?php

namespace App\Controller;

use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController
{
    #[Route("/contact", name: "contact")]

    public function contact(
        EntityManagerInterface $doctrine,
        Request $request
    ): Response {
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $team = $form->getData();

            return $this->renderForm("Proyect/contact.html.twig");
        }
    }
}
