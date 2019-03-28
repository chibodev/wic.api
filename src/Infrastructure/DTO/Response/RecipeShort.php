<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\PublicInterface\DTO\RecipeShortInterface;
use App\Infrastructure\ValueObject\RecipeType;

class RecipeShort implements RecipeShortInterface
{
    /** @var string */
    private $name;
    /** @var int|null */
    private $prep;
    /** @var int|null */
    private $cook;
    /** @var string */
    private $uuid;
    /** @var string */
    private $type;
    /** @var string|null */
    private $imageLink;

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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setName(string $name): void
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

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setImageLink(?string $imageLink): void
    {
        $this->imageLink = $imageLink;
    }
}
