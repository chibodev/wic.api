<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\Infrastructure\PublicInterface\DTO\NotFoundInterface;
use App\Infrastructure\PublicInterface\DTO\RecipeInterface;
use App\Infrastructure\PublicInterface\DTO\RecipeShortInterface;
use Exception;

interface RecipeView
{
    /**
     * @return RecipeShortInterface|NotFoundInterface
     * @throws Exception
     */
    public function getRecipeByMealContent(string $mealContent);

    /**
     * @return RecipeInterface|NotFoundInterface
     * @throws Exception
     */
    public function getRecipeByUuid(string $uuid);
}
