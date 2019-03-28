<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\Infrastructure\DTO\Response\Ingredient as IngredientDTO;
use App\Infrastructure\Entity\Ingredient;
use App\Infrastructure\Entity\Recipe;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface IngredientRepositoryInterface
{
    /**
     * @return IngredientDTO[]
     */
    public function findOneByRecipeForDto(Recipe $recipe): ?array;
}
