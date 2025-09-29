<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manual')]
class ManualController extends  AbstractController
{

    #[Route('/text', name: 'app_text')]
    public function firstMethod(): Response
    {
        return new Response('tessssssssssssstttt');
    }
    #[Route('/html', name: "app_html")]
    public function htmlRender()
    {
        return $this->render('renders/index.html.twig');
    }

    #[Route('/json', name: 'app_json')]
    public function jsonResponse(): JsonResponse
    {
        $data = [
            'status' => 'success',
            'message' => 'Voici une réponse JSON',
        ];

        return $this->json($data);
    }
}
