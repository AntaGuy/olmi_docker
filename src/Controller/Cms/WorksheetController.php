<?php

namespace App\Controller\Cms;

use App\Entity\Family;
use App\Entity\Worksheet;
use App\Repository\WorksheetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tous-les-travaux")
 */
class WorksheetController extends AbstractController
{
    /**
     * @Route("/{family_slug}/{slug}", name="worksheet_show", methods={"GET"})
     * @Entity("worksheet", expr="repository.findOneBySlug(slug)")
     */
    public function show(Worksheet $worksheet): Response
    {
        if (!$worksheet->getPage()->getEnabled()) {
            throw $this->createNotFoundException('The page does not exist');
        }

        return $this->render('cms/worksheet/show.html.twig', [
            'aids' => $worksheet->getAids(),
            'panel' => $worksheet->getPanel(),
            'page' => $worksheet->getPage(),
        ]);
    }
}
