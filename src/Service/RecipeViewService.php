<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\NotFound;
use App\DTO\Response\Recipe;
use App\Entity\Unknown;
use App\Repository\RecipeRepository;
use App\Repository\UnknownRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class RecipeViewService
{
    private $recipeRepo;
    private $unknownRepo;
    private $entityManager;

    public function __construct(RecipeRepository $recipeRepo, UnknownRepository $unknownRepo, EntityManagerInterface $entityManager)
    {
        $this->recipeRepo = $recipeRepo;
        $this->unknownRepo = $unknownRepo;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Recipe|NotFound
     * @throws Exception
     */
    public function getRecipeByMealContent(string $mealContent)
    {
        $recipe = $this->recipeRepo->findByMealContent($mealContent);

        if(!$recipe){
            $unknown = $this->unknownRepo->findOneBy(['term' => $mealContent]);
            if($unknown) {
                $unknown->updateCounter();
            }
            else{
                $unknown = new Unknown($mealContent);
            }
            $this->unknownRepo->save($unknown);
            return new NotFound(sprintf('Unfortunately there is no available recipe at this point in time.'));
        }

        //TODO expand to return Recipe DTO
        return new Recipe();
    }
}
