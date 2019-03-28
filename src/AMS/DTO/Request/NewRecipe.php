<?php

declare(strict_types=1);

namespace App\AMS\DTO\Request;

use App\Infrastructure\ValueObject\RecipeType;

class NewRecipe
{
    private $name;
    private $prep;
    private $cook;
    private $ingredient;
    private $direction;
    /** @var RecipeType */
    private $type;

}
