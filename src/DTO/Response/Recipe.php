<?php

declare(strict_types=1);

namespace App\DTO\Response;

use App\ValueObject\RecipeType;

class Recipe
{
    /** @var string */
    private $name;
    /** @var int|null */
    private $prep;
    /** @var int|null */
    private $cook;
    /** @var string */
    private $author;
    /** @var Ingredient[] */
    private $ingredient;
    /** @var Direction[] */
    private $direction;
    /** @var string */
    private $type;

    public function __construct(string $name,
        ?int $prepInMinutes,
        ?int $cookInMinutes,
        array $ingredient,
        array $direction,
        RecipeType $type,
        string $author = 'N/A'
    ) {
        $this->name = $name;
        $this->prep = $prepInMinutes;
        $this->cook = $cookInMinutes;
        $this->ingredient = $ingredient;
        $this->direction = $direction;
        $this->author = $author;
        $this->type = $type->getValue();
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

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
