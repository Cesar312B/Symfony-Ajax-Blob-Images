<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerifidController extends AbstractController
{
    /**
     * @Route("/verifid", name="app_verifid")
     */
    public function index(): Response
    {
        return $this->render('verifid/index.html.twig', [
            'controller_name' => 'Usuario Verificado',
        ]);
    }
}
