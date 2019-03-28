<?php

declare(strict_types=1);

namespace App\AMS\Controller;

use App\AMS\Form\RecipeType;
use App\Infrastructure\PublicInterface\DTO\MealContentInterface as MealContentRequestDTO;
use App\Infrastructure\PublicInterface\DTO\NotFoundInterface as NotFoundResponseDTO;
use App\Infrastructure\PublicInterface\RecipeView;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    private $recipeService;

    public function __construct(RecipeView $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * @Route("/", name="recipe")
     *
     * @throws Exception
     */
    public function recipeBySearchTermAction(Request $request, MealContentRequestDTO $mealContent): Response
    {
        $form = $this->createForm(RecipeType::class, $mealContent);

        $form->handleRequest($request);

        $params = ['status' => 'red'];

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var MealContentRequestDTO $mealContent */
            $mealContent = $form->getData();

            $recipe = $this->recipeService->getRecipeByMealContent($mealContent->getMealContent());

            if ($recipe instanceof NotFoundResponseDTO){
                $params['status'] = 'yellow';
                $params['message'] = $recipe->getMessage();
            }
            else {

                $params['status'] = 'green';
                $recipes = [];
                foreach ($recipe as $item) {
                    $recipes[] = $item;
                }
                $params['recipes'] = $recipes;
            }
        }
        return $this->render('Recipe/search.html.twig', ['searchForm' => $form->createView(), 'data' => $params]);
    }

    /**
     * @Route("/get/{uuid}", name="recipe_uuid")
     *
     * @throws Exception
     */
    public function recipeByUuidAction(string $uuid): Response
    {

        $recipe = $this->recipeService->getRecipeByUuid($uuid);

        if ($recipe instanceof NotFoundResponseDTO){
            $params['status'] = 'red';
            $this->addFlash('error', $recipe->getMessage());
        }
        else {
            $params['status'] = 'green';
            $params['recipe'] = $recipe;
        }

        return $this->render('Recipe/recipe.html.twig', ['data' => $params]);
    }

    /**
     * @Route("/recipe/add", name="add-recipe")
     */
    public function addAction(Request $request): Response
    {
        return $this->render('Recipe/add.html.twig');
    }
}
