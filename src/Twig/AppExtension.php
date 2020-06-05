<?php
namespace App\Twig;

use App\Repository\PageBlockRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('ondisk', 'file_exists'),
        ];
    }
}
