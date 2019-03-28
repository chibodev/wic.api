<?php

declare(strict_types=1);

namespace App\EntityInterface;

use DateTimeImmutable;

interface RecipeInterface
{
    public function getId(): ?int;

    public function getName(): string;

    public function getUuid(): string;

    public function setIngredient(?IngredientInterface $ingredient): void;

    public function getIngredient(): ?IngredientInterface;

    public function getPrep(): ?int;

    public function getCook(): ?int;

    public function getCreatedAt(): DateTimeImmutable;

    public function setPrep(int $prep): void;

    public function setCook(int $cook): void;

    public function getDirection(): ?DirectionInterface;

    public function setDirection(?DirectionInterface $direction): void;

    public function getAuthor(): string;

    public function setAuthor(string $source): void;

    public function getType(): RecipeTypeInterface;

    public function setImageLink(string $imageLink): void;

    public function getImageLink(): ?string;

    public function setImageSource(string $imageSource): void;

    public function getImageSource(): ?string;
}

