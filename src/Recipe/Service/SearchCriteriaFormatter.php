<?php

declare(strict_types=1);

namespace App\Recipe\Service;

use App\Recipe\Formatter\Cleanup;

class SearchCriteriaFormatter implements SearchCriteriaFormat
{
    /** @var Cleanup[] */
    private $criteria;

    public function __construct(iterable $criteria)
    {
        $this->criteria = $criteria;
    }

    public function apply(string $searchCriteria): string
    {
        foreach ($this->criteria as $criterion) {
            $searchCriteria = $criterion->apply($searchCriteria);
        }

        return $searchCriteria;
    }
}
