<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\NotFound;
use App\DTO\Response\Recipe;
use App\DTO\Response\RecipeShort;
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
