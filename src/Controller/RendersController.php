<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RendersController extends AbstractController
{
    #[Route('/renders', name: 'app_renders')]
    public function index(): Response
    {
        return $this->render('renders/index.html.twig', [
            'controller_name' => 'RendersController',
        ]);
    }



    #[Route('/message', name: 'app_message')]
    public function message(): Response
    {
        return new Response("Ceci est une réponse en texte brut !");
    }

    #[Route('/twig', name: 'app_twig')]
    public function twig(): Response
    {
        return $this->render('demo/index.html.twig', [
            'nom' => 'Emna',
            'age' => 25,
        ]);
    }

    #[Route('/json', name: 'app_json')]
    public function jsonResponse(): JsonResponse
    {
        $data = [
            'status' => 'success',
            'message' => 'Voici une réponse JSON',
            'user' => [
                'id' => 1,
                'name' => 'Emna'
            ]
        ];

        return $this->json($data); // utilise la méthode héritée d'AbstractController
    }


    #[Route('/redirect', name: 'app_redirect')]
    public function redirectToMessage(): Response
    {
        // Rediriger vers la route "app_message"
        return $this->redirectToRoute('app_message');
    }
}
