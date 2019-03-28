<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\EntityInterface\RecipeInterface;

/**
 * @method RecipeInterface|null findOneBy(array $criteria, array $orderBy = null)
 */
interface RecipeRepositoryInterface
{
    /**
     * @return RecipeInterface[]
     */
    public function findByMealContent(array $mealContents): ?array;
}
