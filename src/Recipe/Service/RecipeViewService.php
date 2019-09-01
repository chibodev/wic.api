<?php

declare(strict_types=1);

namespace App\Recipe\Service;

use App\Recipe\Entity\Recipe as RecipeEntity;
use App\Recipe\DTO\Response\Recipe;
use App\Recipe\DTO\Response\RecipeShort;
use App\Recipe\Entity\Unknown;
use App\Recipe\PublicInterface\DTO\NotFoundInterface;
use App\Recipe\PublicInterface\RecipeView;
use App\Recipe\Repository\DirectionRepository;
use App\Recipe\Repository\IngredientRepository;
use App\Recipe\Repository\RecipeRepository;
use App\Recipe\Repository\UnknownRepository;
use Exception;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\Validator\Constraints\Uuid as UuidConstraint;
use Symfony\Component\Validator\Validation;

class RecipeViewService implements RecipeView
{
    private $recipeRepo;
    private $unknownRepo;
    private $ingredientRepo;
    private $directionRepo;
    private $logger;

    private $notFound;
    private $recipeDto;
    private $searchCriteriaFormatter;

    public function __construct(
        RecipeRepository $recipeRepo,
        UnknownRepository $unknownRepo,
        IngredientRepository $ingredientRepo,
        DirectionRepository $directionRepo,
        NotFoundInterface $notFound,
        Recipe $recipeDto,
        SearchCriteriaFormat $searchCriteriaFormatter,
        LoggerInterface $logger
    ) {
        $this->recipeRepo = $recipeRepo;
        $this->unknownRepo = $unknownRepo;
        $this->ingredientRepo = $ingredientRepo;
        $this->directionRepo = $directionRepo;
        $this->logger = $logger;
        $this->notFound = $notFound;
        $this->recipeDto = $recipeDto;
        $this->searchCriteriaFormatter = $searchCriteriaFormatter;
    }

    public function getRecipeByMealContent(string $mealContent, bool $limitation = false)
    {
        $searchCriteria = $this->getFormattedSearchCriteria($mealContent);
        $recipes = !empty($searchCriteria) ? $this->recipeRepo->findByMealContent($searchCriteria, $limitation) : null;

        if(!$recipes){

            $unknown = $this->unknownRepo->findOneBy(['term' => $mealContent]);
            if($unknown) {
                $unknown->updateCounter();
            }
            else {
                $unknown = new Unknown($mealContent);
            }
            $this->unknownRepo->save($unknown);

            $this->notFound->setMessage(
                sprintf('Unfortunately there is no available recipe/ingredient associated with "%s" at this point in time.', $mealContent)
            );

            return $this->notFound;
        }

        $recipeDto = [];

        /** @var RecipeEntity $recipe */
        foreach ($recipes as $recipe){
            $recipeShort = new RecipeShort();
            $recipeShort->setName($recipe->getName());
            $recipeShort->setUuid($recipe->getUuid());
            $recipeShort->setPrep($recipe->getPrep());
            $recipeShort->setCook($recipe->getCook());
            $recipeShort->setType($recipe->getType()->getValue());
            $recipeShort->setImageUrl($recipe->getImageUrl());
            $recipeDto[] = $recipeShort;
        }

        return $recipeDto;
    }

    public function getRecipeByUuid(string $uuid)
    {
        if (!$this->isUuidValid($uuid)){
            $this->logger->info(sprintf('invalid uuid entered: %s', $uuid));
            throw new RuntimeException(sprintf('invalid uuid entered: %s', $uuid));
        }

        $recipe = $this->recipeRepo->findOneBy(['uuid' => $uuid]);

        if(!$recipe) {
            $this->notFound->setMessage(
                sprintf('No recipe associated with the entered id "%s"', $uuid)
            );
            return $this->notFound;
        }

        $direction = $this->directionRepo->findOneByRecipeForDto($recipe);
        $ingredient = $this->ingredientRepo->findOneByRecipeForDto($recipe);

        $this->recipeDto->setName($recipe->getName());
        $this->recipeDto->setPrep($recipe->getPrep());
        $this->recipeDto->setCook($recipe->getCook());
        $this->recipeDto->setIngredient($ingredient);
        $this->recipeDto->setDirection($direction);
        $this->recipeDto->setType($recipe->getType()->getValue());
        $this->recipeDto->setImageUrl($recipe->getImageUrl());
        $this->recipeDto->setImageSource($recipe->getImageSource());
        $this->recipeDto->setAuthor($recipe->getAuthor());

        return $this->recipeDto;
    }

    private function getFormattedSearchCriteria(string $mealContent): array
    {
        return str_word_count($this->searchCriteriaFormatter->apply($mealContent), 1);
    }

    /**
     * @throws Exception
     */
    private function isUuidValid(string $uuid): bool
    {
        $validator = Validation::createValidator();

        $uuidConstraint = new UuidConstraint();

        $errors = $validator->validate(
            $uuid,
            $uuidConstraint
        );

        return count($errors) === 0;
    }
}
