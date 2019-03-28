<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\ValueObject\RecipeType;

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
    /** @var string|null */
    private $imageLink;
    /** @var string|null */
    private $imageSource;

    public function __construct(string $name,
        ?int $prepInMinutes,
        ?int $cookInMinutes,
        array $ingredient,
        array $direction,
        RecipeType $type,
        ?string $imageLink,
        ?string $imageSource,
        string $author = 'N/A'
    ) {
        $this->name = $name;
        $this->prep = $prepInMinutes;
        $this->cook = $cookInMinutes;
        $this->ingredient = $ingredient;
        $this->direction = $direction;
        $this->author = $author;
        $this->type = $type->getValue();
        $this->imageLink = $imageLink;
        $this->imageSource = $imageSource;
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

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function getImageSource(): ?string
    {
        return $this->imageSource;
    }
}
