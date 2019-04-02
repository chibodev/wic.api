<?php

declare(strict_types=1);

namespace App\Infrastructure\ValueObject;

use App\EntityInterface\RecipeTypeInterface;
use MyCLabs\Enum\Enum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class RecipeType extends Enum implements RecipeTypeInterface
{
    /**
     * @ORM\Column(type="string", name="type")
     */
    protected $value;
}
