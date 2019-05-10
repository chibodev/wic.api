<?php

declare(strict_types=1);

namespace App\Recipe\PublicInterface\DTO;

interface IngredientInterface
{
    public function getDescription(): ?string;

    public function getQuantity(): ?float;

    public function getUnit(): ?string;
}
