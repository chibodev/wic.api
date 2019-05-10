<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface;

use App\Recipe\PublicInterface\DTO\NotFoundInterface;
use App\Recipe\PublicInterface\DTO\RecipeInterface;
use App\Recipe\PublicInterface\DTO\RecipeShortInterface;
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
