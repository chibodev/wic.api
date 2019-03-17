<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]|null    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
        $queryBuilder = $this->_em->createQueryBuilder();

        var_dump($mealContent);

        $queryBuilder
            ->select('recipe')
            ->from(Recipe::class, 'recipe')
            ->innerJoin(Ingredient::class, 'ingredient', Join::WITH, 'ingredient.recipe = recipe')
            ->where('REGEXP(recipe.name, :mealContent) = true')
            ->orWhere('REGEXP(ingredient.description, :mealContent) = true')
            ->setParameter('mealContent', $mealContent)
            ->distinct()
        ;

        var_dump($queryBuilder->getQuery()->getSQL());

        return $queryBuilder->getQuery()->getResult();
    }
}
