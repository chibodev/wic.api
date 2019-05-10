<?php

declare(strict_types=1);

namespace App\Recipe\Repository;

use App\EntityInterface\RecipeInterface;
use App\Recipe\Entity\Ingredient;
use App\Recipe\PublicInterface\DTO\IngredientInterface;
use App\Recipe\PublicInterface\IngredientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IngredientInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientInterface[]    findAll()
 * @method IngredientInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository implements IngredientRepositoryInterface
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function findOneByRecipeForDto(RecipeInterface $recipe): ?array
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        $queryBuilder->select(
            'new App\Recipe\DTO\Response\Ingredient(
                ingredient.description,
                ingredient.quantity,
                ingredient.unit
            )'
        );

        $queryBuilder
            ->from(Ingredient::class, 'ingredient')
            ->where('ingredient.recipe = :recipe')
            ->setParameter('recipe', $recipe)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
