<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface\DTO;

interface MealContentInterface
{
    public function getMealContent(): ?string;

    public function setMealContent(string $content): void;
}