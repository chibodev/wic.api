<?php

declare(strict_types=1);

namespace App\DTO\Response;

use App\ValueObject\RecipeType;

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
    /** @var string */
    private $type;

    public function __construct(string $uuid, string $name, ?int $prepInMinutes, ?int $cookInMinutes, RecipeType $type)
    {
        $this->name = $name;
        $this->prep = $prepInMinutes;
        $this->cook = $cookInMinutes;
        $this->uuid = $uuid;
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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
