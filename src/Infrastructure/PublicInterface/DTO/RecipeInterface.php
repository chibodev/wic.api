<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface\DTO;

interface RecipeInterface
{
    public function getName(): string;

    public function getPrep(): ?int;

    public function getCook(): ?int;

    /**
     * @return IngredientInterface[]
     */
    public function getIngredient(): array;

    /**
     * @return DirectionInterface[]
     */
    public function getDirection(): array;

    public function getAuthor(): string;

    public function getType(): string;

    public function getImageUrl(): ?string;

    public function getImageSource(): ?string;

    public function setName(?string $name): void;

    public function setPrep(?int $prep): void;

    public function setCook(?int $cook): void;

    public function setAuthor(string $author): void;

    public function setIngredient(array $ingredient): void;

    public function setDirection(array $direction): void;

    public function setType(string $type): void;

    public function setImageUrl(?string $imageLink): void;

    public function setImageSource(?string $imageSource): void;

    public function isKeto(): bool;

    public function setKeto(bool $keto): void;
}
