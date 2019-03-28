<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO\Response;

use App\Infrastructure\PublicInterface\DTO\IngredientInterface;

class Ingredient implements IngredientInterface
{
    /** @var string|null */
    private $description;
    /** @var float|null */
    private $quantity;
    /** @var string|null */
    private $unit;

    public function __construct(?string $description, ?float $quantity, ?string $unit)
    {
        $this->description = $description;
        $this->quantity = $quantity;
        $this->unit = $unit;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }
}
