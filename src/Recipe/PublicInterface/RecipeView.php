<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface;

use App\Recipe\DTO\Response\Recipe;
use App\Recipe\DTO\Response\RecipeShort;
use App\Recipe\PublicInterface\DTO\NotFoundInterface;
use Exception;

interface RecipeView
{
    /**
     * @return RecipeShort|NotFoundInterface
     * @throws Exception
     */
    public function getRecipeByMealContent(string $mealContent);

    /**
     * @return Recipe|NotFoundInterface
     * @throws Exception
     */
    public function getRecipeByUuid(string $uuid);
}
