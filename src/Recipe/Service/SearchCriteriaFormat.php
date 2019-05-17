<?php

declare(strict_types=1);

namespace App\Recipe\Service;

interface SearchCriteriaFormat
{
    public function apply(string $searchCriteria): string;
}
