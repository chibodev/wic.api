<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\EntityInterface\RecipeInterface;
use App\Infrastructure\DTO\Response\Direction as DirectionDTO;

interface DirectionRepositoryInterface
{
    /**
     * @return DirectionDTO[]
     */
    public function findOneByRecipeForDto(RecipeInterface $recipe): array;
}
