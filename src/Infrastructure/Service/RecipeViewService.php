<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\EntityInterface\RecipeInterface as RecipeEntityInterface;
use App\Infrastructure\DTO\Response\RecipeShort;
use App\Infrastructure\Entity\Unknown;
use App\Infrastructure\PublicInterface\DirectionRepositoryInterface;
use App\Infrastructure\PublicInterface\DTO\NotFoundInterface;
use App\Infrastructure\PublicInterface\DTO\RecipeInterface;
use App\Infrastructure\PublicInterface\IngredientRepositoryInterface;
use App\Infrastructure\PublicInterface\RecipeRepositoryInterface;
use App\Infrastructure\PublicInterface\RecipeView;
use App\Infrastructure\Repository\UnknownRepository;
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

    private const AND = ' and ';
    private const IS = ' is ';
    private const EXCLUDE_CHAR = [
        self::AND,
        self::IS
    ];
    private $notFound;
    private $recipeDto;

    public function __construct(
        RecipeRepositoryInterface $recipeRepo,
        UnknownRepository $unknownRepo,
        IngredientRepositoryInterface $ingredientRepo,
        DirectionRepositoryInterface $directionRepo,
        NotFoundInterface $notFound,
        RecipeInterface $recipeDto,
        LoggerInterface $logger
    ) {
        $this->recipeRepo = $recipeRepo;
        $this->unknownRepo = $unknownRepo;
        $this->ingredientRepo = $ingredientRepo;
        $this->directionRepo = $directionRepo;
        $this->logger = $logger;
        $this->notFound = $notFound;
        $this->recipeDto = $recipeDto;
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

            $this->notFound->setMessage(
                sprintf('Unfortunately there is no available recipe/ingredient associated with "%s" at this point in time.', $mealContent)
            );

            return $this->notFound;
        }

        $recipeDto = [];

        /** @var RecipeEntityInterface $recipe */
        foreach ($recipes as $recipe){
            $recipeShort = new RecipeShort();
            $recipeShort->setName($recipe->getName());
            $recipeShort->setUuid($recipe->getUuid());
            $recipeShort->setPrep($recipe->getPrep());
            $recipeShort->setCook($recipe->getCook());
            $recipeShort->setType($recipe->getType());
            $recipeShort->setImageUrl($recipe->getImageUrl());
            $recipeShort->setKeto($recipe->isKeto());
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
        $this->recipeDto->setType($recipe->getType());
        $this->recipeDto->setImageUrl($recipe->getImageUrl());
        $this->recipeDto->setImageSource($recipe->getImageSource());
        $this->recipeDto->setAuthor($recipe->getAuthor());
        $this->recipeDto->setKeto($recipe->isKeto());

        return $this->recipeDto;
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
