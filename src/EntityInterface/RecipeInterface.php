<?php

declare(strict_types=1);

namespace App\EntityInterface;

use DateTime;

interface RecipeInterface
{
    public function setName(string $name): void;

    public function getName(): ?string;

    public function getUuid(): string;

    public function setIngredient(?IngredientInterface $ingredient): void;

    public function getIngredient(): ?IngredientInterface;

    public function getPrep(): ?int;

    public function getCook(): ?int;

    public function getCreatedAt(): DateTime;

    public function setPrep(int $prep): void;

    public function setCook(int $cook): void;

    public function getDirection(): ?DirectionInterface;

    public function setDirection(DirectionInterface $direction): void;

    public function getAuthor(): ?string;

    public function setAuthor(string $source): void;

    public function setType(string $type): void;

    public function getType(): string;

    public function setImageUrl(string $imageUrl): void;

    public function getImageUrl(): ?string;

    public function setImageSource(string $imageSource): void;

    public function getImageSource(): ?string;

    public function isKeto(): bool;
}
