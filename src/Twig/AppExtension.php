<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('showDate', [$this, 'showDateFilter']),
        ];
    }

    public function showDateFilter($date)
    {
        if ($date instanceof \DateTime){
            return $date->format('d.m.Y');
        }

        return '';
    }
}
