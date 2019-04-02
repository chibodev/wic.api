<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\PublicInterface\DTO\RecipeShortInterface;

class RecipeShort implements RecipeShortInterface
{
    /** @var string */
    private $name;
    /** @var int|null */
    private $prep;
    /** @var int|null */
    private $cook;
    /** @var bool */
    private $keto;
    /** @var string */
    private $uuid;
    /** @var string */
    private $type;
    /** @var string|null */
    private $imageUrl;

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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
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

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function isKeto(): bool
    {
        return $this->keto;
    }

    public function setKeto(bool $keto): void
    {
        $this->keto = $keto;
    }
}
