<?php

declare(strict_types=1);

namespace App\Infrastructure\PublicInterface;

use App\Infrastructure\DTO\Response\Direction as DirectionDTO;
use App\Infrastructure\Entity\Direction;
use App\Infrastructure\Entity\Recipe;

/**
 * @method Direction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Direction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Direction[]    findAll()
 * @method Direction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface DirectionRepositoryInterface
{
    /**
     * @return DirectionDTO[]
     */
    public function findOneByRecipeForDto(Recipe $recipe): array;
}
