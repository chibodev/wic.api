<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\PublicInterface\DTO\DirectionInterface;

class Direction implements DirectionInterface
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
