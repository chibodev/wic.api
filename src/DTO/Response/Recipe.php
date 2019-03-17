<?php

declare(strict_types=1);

namespace App\DTO\Response;

class Recipe
{
    /** @var string */
    private $name;
    /** @var int|null */
    private $prep;
    /** @var int|null */
    private $cook;
    /** @var Ingredient[] */
    private $ingredient;
    /** @var Direction[] */
    private $direction;

    public function __construct(string $name, ?int $prepInMinutes, ?int $cookInMinutes, array $ingredient, array $direction)
    {
        $this->name = $name;
        $this->prep = $prepInMinutes;
        $this->cook = $cookInMinutes;
        $this->ingredient = $ingredient;
        $this->direction = $direction;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrep(): ?int
    {
        return $this->prep;
    }

    public function getCook(): ?int
    {
        return $this->cook;
    }

    public function getIngredient(): array
    {
        return $this->ingredient;
    }

    public function getDirection(): array
    {
        return $this->direction;
    }
}
