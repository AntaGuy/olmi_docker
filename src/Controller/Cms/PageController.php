<?php

namespace App\Controller\Cms;

use App\Entity\Aid;
use App\Entity\Family;
use App\Entity\Page;
use App\Entity\PageBlock;
use App\Entity\Worksheet;
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
     * @Route("/{slug}", name="page_show", methods={"GET"})
     */
    public function show(Page $page): Response
    {
        if (!$page->getEnabled()) {
            throw $this->createNotFoundException('The page does not exist');
        }

        if ($page->getFamily() instanceof Family) {
            return $this->redirectToRoute('family_show', ['slug' => $page->getSlug()]);
        }

        if ($page->getWorksheet() instanceof Worksheet) {
            return $this->redirectToRoute('worksheet_show', ['slug' => $page->getSlug(), 'family_slug' => $page->getWorksheet()->getFamily()->getSlug()]);
        }

        if ($page->getAid() instanceof Aid) {
            return $this->redirectToRoute('aid_show', ['slug' => $page->getSlug()]);
        }

        return $this->render('cms/page/show.html.twig', [
            'page' => $page,
        ]);
    }
}
