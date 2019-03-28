<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Ingredient;
use App\Infrastructure\Entity\Recipe;
use App\Infrastructure\PublicInterface\RecipeRepositoryInterface;
use App\Infrastructure\Service\LikeQueryHelpers;
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
class RecipeRepository extends ServiceEntityRepository implements RecipeRepositoryInterface
{
    use LikeQueryHelpers;

    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function findByMealContent(array $mealContents): ?array
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        $queryBuilder
            ->select('recipe')
            ->from(Recipe::class, 'recipe')
            ->innerJoin(Ingredient::class, 'ingredient', Join::WITH, 'ingredient.recipe = recipe')
        ;

        foreach ($mealContents as $index => $mealContent) {
            $queryBuilder->orWhere("recipe.name LIKE :mealContent$index ESCAPE '!'");
            $queryBuilder->setParameter("mealContent$index", $this->makeLikeParam($mealContent));
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
