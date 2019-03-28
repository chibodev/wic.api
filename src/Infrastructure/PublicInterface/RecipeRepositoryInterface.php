<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\Infrastructure\Entity\Recipe;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]|null    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface RecipeRepositoryInterface
{
    /**
     * @return Recipe[]
     */
    public function findByMealContent(array $mealContents): ?array;
}
