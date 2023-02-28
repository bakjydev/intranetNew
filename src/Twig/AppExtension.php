<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('diff', [$this, 'calculateDateDiff']),
        ];
    }

    public function calculateDateDiff(\DateTime $date1, \DateTime $date2): \DateInterval
    {
        return $date1->diff($date2);
    }
}