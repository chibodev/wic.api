<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @return Recipe[]|null
     */
    public function findByMealContent(string $mealContent): ?array
    {
        $queryBuilder = $this->_em->createQueryBuilder('recipe');

        $queryBuilder
            ->join(Ingredient::class, 'ingredient')
            ->where($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('recipe.name', ':mealContent'),
                $queryBuilder->expr()->like('ingredient.description', ':mealContent')
            ))
            ->setParameter('mealContent', $mealContent)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
