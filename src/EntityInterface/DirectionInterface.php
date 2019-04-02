<?php

declare(strict_types=1);

namespace App\EntityInterface;

interface DirectionInterface
{
    public function getDescription(): ?string;

    public function setDescription(string $description): void;

    public function getRecipe(): ?RecipeInterface;
}
