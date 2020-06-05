<?php
namespace App\Twig;

use App\Entity\PageBlock;
use App\Repository\PageBlockRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlockTypesExtension extends AbstractExtension
{
    protected $blockRepository;

    public function __construct(PageBlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('blockTypes', [$this, 'getBlockTypes']),
        ];
    }

    public function getBlockTypes($page)
    {
        $blocks = $this->blockRepository->findByPage($page);
        $blocksByType = [];

        foreach ($blocks as $block) {
            $blocksByType[$block->getTypesToString()][] = $block;
        }

        return $blocksByType;
    }
}
