<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\NotFound;
use App\DTO\Response\Recipe;
use Exception;

interface RecipeView
{
    /**
     * @return Recipe|NotFound
     * @throws Exception
     */
    public function getRecipeByMealContent(string $mealContent);
}
