<?php

declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class MealContent
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $mealContent;

    public function getMealContent(): ?string
    {
        return $this->mealContent;
    }

    public function setMealContent(string $content): void
    {
        $this->mealContent = $content;
    }
}
