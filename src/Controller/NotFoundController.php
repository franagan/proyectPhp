<?php

namespace App\Controller;

// src/Controller/NotFoundController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotFoundController
{
    #[Route("/not-found", name: "notFound")]

    public function notFound(): Response
    {
        return new Response('Error 404: Page not found');
    }
}
