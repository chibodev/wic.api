<?php

declare(strict_types=1);

namespace App\EntityInterface;

interface RecipeTypeInterface
{
    public const BEVERAGE = 'BEVERAGE';
    public const FOOD = 'FOOD';
    public const INCONCLUSIVE = 'INCONCLUSIVE';

    /**
     * @return mixed
     */
    public function getValue();
}
