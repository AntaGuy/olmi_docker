<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/homepage",
     *     "fr": "/accueil"
     * }, name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', []);
    }
}
