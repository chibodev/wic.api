<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\EntityInterface\RecipeInterface;
use App\Infrastructure\DTO\Response\Ingredient as IngredientDTO;

interface IngredientRepositoryInterface
{
    /**
     * @return IngredientDTO[]
     */
    public function findOneByRecipeForDto(RecipeInterface $recipe): ?array;
}
