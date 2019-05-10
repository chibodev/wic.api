<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface;

use App\EntityInterface\RecipeInterface;
use App\Recipe\DTO\Response\Ingredient as IngredientDTO;

interface IngredientRepositoryInterface
{
    /**
     * @return IngredientDTO[]
     */
    public function findOneByRecipeForDto(RecipeInterface $recipe): ?array;
}
