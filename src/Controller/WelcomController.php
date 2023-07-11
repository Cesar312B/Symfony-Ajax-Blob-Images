<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomController extends AbstractController
{
    /**
     * @Route("/welcom", name="app_welcom")
     */
    public function index(): Response
    {
        return $this->render('welcom/index.html.twig', [
            'controller_name' => 'WelcomController',
        ]);
    }
}
