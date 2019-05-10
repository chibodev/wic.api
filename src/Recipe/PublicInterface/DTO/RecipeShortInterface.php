<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface\DTO;

interface RecipeShortInterface
{
    public function getName(): string;

    public function getPrep(): ?int;

    public function getCook(): ?int;

    public function getUuid(): string;

    public function getType(): string;

    public function getImageUrl(): ?string;

    public function setName(string $name): void;

    public function setPrep(?int $prep): void;

    public function setCook(?int $cook): void;

    public function setUuid(string $uuid): void;

    public function setType(string $type): void;

    public function setImageUrl(?string $imageUrl): void;
}
