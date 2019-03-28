<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\Infrastructure\DTO\Response\NotFound;
use App\Infrastructure\DTO\Response\Recipe;
use App\Infrastructure\DTO\Response\RecipeShort;
use Exception;

interface RecipeView
{
    /**
     * @return RecipeShort|NotFound
     * @throws Exception
     */
    public function getRecipeByMealContent(string $mealContent);

    /**
     * @return Recipe|NotFound
     * @throws Exception
     */
    public function getRecipeByUuid(string $uuid);
}
