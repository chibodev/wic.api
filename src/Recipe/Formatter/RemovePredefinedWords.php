<?php

declare(strict_types=1);

namespace App\Recipe\Formatter;

class RemovePredefinedWords implements Cleanup
{
    private const AND = 'and';
    private const IS = 'is';
    private const EXCLUDE_CHAR = [
        self::AND,
        self::IS
    ];

    public function apply(string $searchCriteria): string
    {
        $criteria = explode(' ', $searchCriteria);

        foreach ($criteria as $key => $item)
        {
            if (\in_array($item, self::EXCLUDE_CHAR, true)) {
                unset($criteria[$key]);
            }
        }

        return implode(' ', $criteria);
    }
}
