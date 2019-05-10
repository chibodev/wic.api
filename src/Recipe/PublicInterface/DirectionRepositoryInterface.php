<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface;

use App\EntityInterface\RecipeInterface;
use App\Recipe\DTO\Response\Direction as DirectionDTO;

interface DirectionRepositoryInterface
{
    /**
     * @return DirectionDTO[]
     */
    public function findOneByRecipeForDto(RecipeInterface $recipe): array;
}
