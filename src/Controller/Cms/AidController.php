<?php

namespace App\Controller\Cms;

use App\Entity\Aid;
use App\Repository\AidRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/toutes-les-aides")
 */
class AidController extends AbstractController
{
    /**
     * @Route("/", name="aid_index", methods={"GET"})
     */
    public function index(AidRepository $aidRepository): Response
    {
        return $this->render('cms/aid/index.html.twig', [
            'aids' => $aidRepository->findByEnabled(1),
        ]);
    }

    /**
     * @Route("/{slug}", name="aid_show", methods={"GET"})
     * @Entity("aid", expr="repository.findOneBySlug(slug)")
     */
    public function show(Aid $aid): Response
    {
        if (!$aid->getPage()->getEnabled()) {
            throw $this->createNotFoundException('The page does not exist');
        }

        return $this->render('cms/aid/show.html.twig', [
            'panel' => $aid->getPanel(),
            'page' => $aid->getPage(),
        ]);
    }
}
