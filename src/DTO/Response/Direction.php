<?php

declare(strict_types=1);

namespace App\DTO\Response;

class Direction
{
    /** @var string|null */
    private $description;

    public function __construct(?string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
