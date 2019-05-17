<?php

declare(strict_types=1);

namespace App\Recipe\Formatter;

interface Cleanup
{
    public function apply(string $mealContent): string;
}
