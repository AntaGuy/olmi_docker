<?php

namespace App\Controller\Cms;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use App\Repository\WorksheetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tous-les-travaux")
 */
class FamilyController extends AbstractController
{
    protected $worksheetRepository;

    public function __construct(WorksheetRepository $worksheetRepository)
    {
        $this->worksheetRepository = $worksheetRepository;
    }

    /**
     * @Route("/", name="family_index", methods={"GET"})
     */
    public function index(FamilyRepository $familyRepository): Response
    {
        return $this->render('cms/family/index.html.twig', [
            'families' => $familyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{slug}", name="family_show", methods={"GET"})
     * @Entity("family", expr="repository.findOneBySlug(slug)")
     */
    public function show(Family $family): Response
    {
        if (!$family->getPage()->getEnabled()) {
            throw $this->createNotFoundException('The page does not exist');
        }

        return $this->render('cms/family/show.html.twig', [
            'worksheets' => $this->worksheetRepository->findByEnabledByFamily($family),
            'page' => $family->getPage(),
        ]);
    }
}
