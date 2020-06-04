<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Entity\Family;
use App\Entity\Page;
use App\Entity\PageBlock;
use App\Entity\Worksheet;
use App\Form\PageType;
use App\Repository\PageBlockRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findByEnabled(1),
        ]);
    }

    /**
     * @Route("/{slug}", name="page_show", methods={"GET"})
     */
    public function show(Aid $aid, PageBlockRepository $blockRepository): Response
    {
        if (!$aid->getPage()->getEnabled()) {
            throw $this->createNotFoundException('The page does not exist');
        }

        $blocks = $blockRepository->findByPage($aid->getPage());
        $blocksByType = [];
        $typesBlock = $this->getParameter('types_block');

        foreach ($blocks as $block) {
            $blocksByType[$block->getType()][] = $block;
        }

        return $this->render('page/aid.html.twig', [
            'panel' => $aid->getPanel(),
            'typesBlock' => $typesBlock,
            'blocks' => $blocksByType,
            'page' => $aid->getPage(),
        ]);
    }
}
