<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\NotFound;
use App\DTO\Response\Recipe;
use App\DTO\Response\RecipeShort;
use App\Entity\Recipe as RecipeEntity;
use App\Entity\Unknown;
use App\Repository\DirectionRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Repository\UnknownRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Uuid as UuidConstraint;

class RecipeViewService implements RecipeView
{
    private $recipeRepo;
    private $unknownRepo;
    private $ingredientRepo;
    private $directionRepo;
    private $logger;

    private const AND = ' and ';
    private const IS = ' is ';
    private const EXCLUDE_CHAR = [
        self::AND,
        self::IS
    ];

    public function __construct(
        RecipeRepository $recipeRepo,
        UnknownRepository $unknownRepo,
        IngredientRepository $ingredientRepo,
        DirectionRepository $directionRepo,
        LoggerInterface $logger
    ) {
        $this->recipeRepo = $recipeRepo;
        $this->unknownRepo = $unknownRepo;
        $this->ingredientRepo = $ingredientRepo;
        $this->directionRepo = $directionRepo;
        $this->logger = $logger;
    }

    public function getRecipeByMealContent(string $mealContent)
    {
        $recipes = $this->recipeRepo->findByMealContent($this->formatString($mealContent));

        if(!$recipes){

            $unknown = $this->unknownRepo->findOneBy(['term' => $mealContent]);
            if($unknown) {
                $unknown->updateCounter();
            }
            else {
                $unknown = new Unknown($mealContent);
            }
            $this->unknownRepo->save($unknown);

            return new NotFound(sprintf('Unfortunately there is no available recipe/ingredient associated with "%s" at this point in time.', $mealContent));
        }

        $recipeDto = [];

        /** @var RecipeEntity $recipe */
        foreach ($recipes as $recipe){
            $recipeDto[] = new RecipeShort(
                $recipe->getUuid(),
                $recipe->getName(),
                $recipe->getPrep(),
                $recipe->getCook(),
                $recipe->getType(),
                $recipe->getImageLink()
            );
        }

        return $recipeDto;
    }

    public function getRecipeByUuid(string $uuid)
    {
        $recipe = $this->recipeRepo->findOneBy(['uuid' => $uuid]);

        if (!$this->isUuidValid($uuid)){
            $this->logger->info(sprintf('invalid uuid entered: %s', $uuid));
            return new NotFound(sprintf('The parameter "%s" is invalid', $uuid));
        }

        if(!$recipe) {
            return new NotFound(sprintf('No recipe associated with the entered id "%s"', $uuid));
        }

        $direction = $this->directionRepo->findOneByRecipeForDto($recipe);
        $ingredient = $this->ingredientRepo->findOneByRecipeForDto($recipe);

        return new Recipe(
            $recipe->getName(),
            $recipe->getPrep(),
            $recipe->getCook(),
            $ingredient,
            $direction,
            $recipe->getType(),
            $recipe->getImageLink(),
            $recipe->getImageSource(),
            $recipe->getAuthor()
        );
    }

    private function formatString(string $toBeFormatted): array
    {
        $toBeFormatted = strtolower(preg_replace('/[^A-Za-z]\s+/', ' ', $toBeFormatted));    //remove special char + multiple whitespaces
        $toBeFormatted = str_replace(self::EXCLUDE_CHAR, ' ', $toBeFormatted); // remove certain phrase

        return str_word_count($toBeFormatted, 1);
    }

    /**
     * @throws Exception
     */
    private function isUuidValid(string $uuid): bool
    {
        $validator = Validation::createValidator();

        $uuidContraint = new UuidConstraint();

        $errors = $validator->validate(
            $uuid,
            $uuidContraint
        );

        return count($errors) === 0;
    }
}
