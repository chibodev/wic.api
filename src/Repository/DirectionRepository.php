<?php

namespace App\Repository;

use App\DTO\Response\Direction as DirectionDTO;
use App\Entity\Direction;
use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Direction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Direction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Direction[]    findAll()
 * @method Direction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectionRepository extends ServiceEntityRepository
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Direction::class);
    }

    /**
     * @return DirectionDTO[]
     */
    public function findOneByRecipeForDto(Recipe $recipe): array
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        $queryBuilder->select(
            'new App\DTO\Response\Direction(
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
