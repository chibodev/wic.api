<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\NotFound;
use App\DTO\Response\Recipe;
use App\DTO\Response\RecipeShort;
use App\Entity\Recipe as RecipeEntity;
use App\Repository\DirectionRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Repository\UnknownRepository;
use Exception;

class RecipeViewService implements RecipeView
{
    private $recipeRepo;
    private $unknownRepo;
    private $ingredientRepo;
    private $directionRepo;

    public function __construct(
        RecipeRepository $recipeRepo,
        UnknownRepository $unknownRepo,
        IngredientRepository $ingredientRepo,
        DirectionRepository $directionRepo
    ) {
        $this->recipeRepo = $recipeRepo;
        $this->unknownRepo = $unknownRepo;
        $this->ingredientRepo = $ingredientRepo;
        $this->directionRepo = $directionRepo;
    }

    public function getRecipeByMealContent(string $mealContent)
    {
        $recipes = $this->recipeRepo->findByMealContent($this->formatString($mealContent));

        if(!$recipes){
            /*
            $unknown = $this->unknownRepo->findOneBy(['term' => $mealContent]);
            if($unknown) {
                $unknown->updateCounter();
            }
            else {
                $unknown = new Unknown($mealContent);
            }
            $this->unknownRepo->save($unknown);
            */
            return new NotFound(sprintf('Unfortunately there is no available recipe associated with %s at this point in time.', $mealContent));
        }

        $recipeDto = [];

        /** @var RecipeEntity $recipe */
        foreach ($recipes as $recipe){
            $recipeDto[] = new RecipeShort($recipe->getUuid(), $recipe->getName(), $recipe->getPrep(), $recipe->getCook());
        }

        return $recipeDto;
    }

    public function getRecipeByUuid(string $uuid): Recipe
    {
        $recipe = $this->recipeRepo->findOneBy(['uuid' => $uuid]);

        if(!$recipe) {
            throw new Exception(sprintf('No recipe found for the requested uuid %s', $uuid));
        }

        $direction = $this->directionRepo->findOneByRecipeForDto($recipe);
        $ingredient = $this->ingredientRepo->findOneByRecipeForDto($recipe);

        return new Recipe($recipe->getName(), $recipe->getPrep(), $recipe->getCook(), $ingredient, $direction);
    }

    private function formatString(string $toBeFormatted): string
    {
        //TODO: review regular expression
        $toBeFormatted = preg_replace('/\s+/', ' ', $toBeFormatted);
        return str_replace(' ', '|^', $toBeFormatted);
    }
}
