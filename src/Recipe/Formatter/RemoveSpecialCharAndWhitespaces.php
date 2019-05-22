<?php

declare(strict_types=1);

namespace App\Recipe\Formatter;

class RemoveSpecialCharAndWhitespaces implements Cleanup
{
    public function apply(string $searchCriteria): string
    {
        return strtolower(preg_replace('/[^a-zA-Z\s]/', '', $searchCriteria));
    }
}
