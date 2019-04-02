<?php

declare(strict_types=1);

namespace App\EntityInterface;

interface IngredientInterface
{
    public function getDescription(): ?string;

    public function setDescription(string $description): void;

    public function getQuantity(): ?float;

    public function setQuantity(?float $quantity): void;

    public function getUnit(): ?string;

    public function setUnit(?string $unit): void;

    public function getRecipe(): ?RecipeInterface;
}
