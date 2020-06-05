<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Entity\Family;
use App\Entity\Page;
use App\Entity\Worksheet;
use Doctrine\ORM\EntityManager;
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
        return $this->render('homepage/index.html.twig', [
            'pages'      => $this->getDoctrine()->getRepository(Page::class)->findByEnabled(1),
            'aids'       => $this->getDoctrine()->getRepository(Aid::class)->findByEnabled(),
            'worksheets' => $this->getDoctrine()->getRepository(Worksheet::class)->findByEnabled(),
            'families'   => $this->getDoctrine()->getRepository(Family::class)->findByEnabled()
        ]);
    }
}
