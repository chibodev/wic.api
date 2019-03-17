<?php

declare(strict_types=1);

namespace App\DTO\Response;

class RecipeShort
{
    /** @var string */
    private $name;
    /** @var int|null */
    private $prep;
    /** @var int|null */
    private $cook;
    /** @var string */
    private $uuid;

    public function __construct(string $uuid, string $name, ?int $prepInMinutes, ?int $cookInMinutes)
    {
        $this->name = $name;
        $this->prep = $prepInMinutes;
        $this->cook = $cookInMinutes;
        $this->uuid = $uuid;
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

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
