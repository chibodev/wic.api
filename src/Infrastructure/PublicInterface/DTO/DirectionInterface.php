<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface\DTO;

interface DirectionInterface
{
    public function getDescription(): ?string;
}
