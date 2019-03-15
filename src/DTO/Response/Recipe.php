<?php

declare(strict_types=1);

namespace App\DTO\Response;

class Recipe
{
    private $name;
    /** @var int|null */
    private $prep;
    /** @var int|null */
    private $cook;
    /** @var Ingredient[]|null */
    private $ingredient;
    /** @var Direction[]|null */
    private $direction;

    public function getRecipeName(): string
    {
        return $this->name;
    }

    public function getIngredient(): ?array
    {
        return $this->ingredient;
    }

    public function getDirection(): ?array
    {
        return $this->direction;
    }

    public function setRecipeName(string $recipeName): void
    {
        $this->name = $recipeName;
    }

    public function setIngredient(?array $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    public function setDirection(?array $direction): void
    {
        $this->direction = $direction;
    }

    public function getPrep(): ?int
    {
        return $this->prep;
    }

    public function setPrep(?int $prep): void
    {
        $this->prep = $prep;
    }

    public function getCook(): ?int
    {
        return $this->cook;
    }

    public function setCook(?int $cook): void
    {
        $this->cook = $cook;
    }
}
