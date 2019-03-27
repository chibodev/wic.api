<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Request\MealContent;
use App\DTO\Response\NotFound;
use App\Form\RecipeType;
use App\Service\RecipeView;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    private $recipeView;

    public function __construct(RecipeView $recipeView)
    {
        $this->recipeView = $recipeView;
    }

    /*
     * Route Options
     * PUBLIC
     * 1 - get recipe by id (uuid)
     * 2 - get recipes based on search term (ingredient and recipe)
     *
     * PRIVATE - control using aop
     * 1 - get all recipes
     * 2 - add new recipe
     * 3 - edit existing recipe
     *
     */
    /**
     * @Route("/", name="recipe")
     *
     * @throws Exception
     */
    public function recipeBySearchTermAction(Request $request): Response
    {
        $mealContent = new MealContent();
        $form = $this->createForm(RecipeType::class, $mealContent);

        $form->handleRequest($request);

        $params = ['status' => 'red'];

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var MealContent $mealContent */
            $mealContent = $form->getData();

            $recipe = $this->recipeView->getRecipeByMealContent($mealContent->getMealContent());

            if ($recipe instanceof NotFound){
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

        $recipe = $this->recipeView->getRecipeByUuid($uuid);

        if ($recipe instanceof NotFound){
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
