<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\PublicInterface\DTO\RecipeInterface;

class Recipe implements RecipeInterface
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
    private $imageUrl;
    /** @var string|null */
    private $imageSource;

    public function __construct(string $author = 'N/A') {
        $this->author = $author;
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getImageSource(): ?string
    {
        return $this->imageSource;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setPrep(?int $prep): void
    {
        $this->prep = $prep;
    }

    public function setCook(?int $cook): void
    {
        $this->cook = $cook;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setIngredient(array $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    public function setDirection(array $direction): void
    {
        $this->direction = $direction;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setImageUrl(?string $imageLink): void
    {
        $this->imageUrl = $imageLink;
    }

    public function setImageSource(?string $imageSource): void
    {
        $this->imageSource = $imageSource;
    }
}
