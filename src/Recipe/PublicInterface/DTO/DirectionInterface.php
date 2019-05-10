<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface\DTO;

interface DirectionInterface
{
    public function getDescription(): ?string;
}
