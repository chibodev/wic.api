<?php

declare(strict_types=1);

namespace App\Recipe\DTO\Request;

use App\Recipe\PublicInterface\DTO\MealContentInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MealContent implements MealContentInterface
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Regex("/^[a-zA-Z ]+$/", message="The string {{ value }} contains an illegal character: it can only contain letters")
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
