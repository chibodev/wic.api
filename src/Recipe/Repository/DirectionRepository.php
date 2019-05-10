<?php

declare(strict_types=1);

namespace App\Recipe\Repository;

use App\EntityInterface\DirectionInterface;
use App\EntityInterface\RecipeInterface;
use App\Recipe\Entity\Direction;
use App\Recipe\PublicInterface\DirectionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DirectionInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirectionInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirectionInterface[]    findAll()
 * @method DirectionInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectionRepository extends ServiceEntityRepository implements DirectionRepositoryInterface
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Direction::class);
    }

    public function findOneByRecipeForDto(RecipeInterface $recipe): array
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        $queryBuilder->select(
            'new App\Recipe\DTO\Response\Direction(
                direction.description
            )'
        );

        $queryBuilder
            ->from(Direction::class, 'direction')
            ->where('direction.recipe = :recipe')
            ->setParameter('recipe', $recipe)
            ;

        return $queryBuilder->getQuery()->getResult();
    }
}
