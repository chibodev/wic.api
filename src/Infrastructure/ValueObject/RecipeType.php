<?php

declare(strict_types=1);

namespace App\Infrastructure\ValueObject;

use MyCLabs\Enum\Enum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class RecipeType extends Enum
{
    public const BEVERAGE = 'BEVERAGE';
    public const FOOD = 'FOOD';
    public const INCONCLUSIVE = 'INCONCLUSIVE';

    /**
     * @ORM\Column(type="string", name="type")
     */
    protected $value;
}
