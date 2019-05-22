<?php

declare(strict_types=1);

namespace App\Recipe\Repository;

use App\Recipe\Entity\Ingredient;
use App\Recipe\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    /**
     * @throws LogicException
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function findOneByRecipeForDto(Recipe $recipe): ?array
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
