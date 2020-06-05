<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TitleExtenstion extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('title', [$this, 'formatTitle'],  ['pre_escape' => 'html', 'is_safe' => ['html']]),
        ];
    }

    public function formatTitle($title)
    {
        if (preg_match('/\/\/(.*?)\/\//', $title, $match) === 1) {
            $title = str_replace( $match[0], '<span class="highlight">' . $match[1] . '</span>', $title);
        }

        return $title;
    }
}
