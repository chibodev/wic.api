<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
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
     * @Route("/get/recipe", name="recipe")
     */
    public function recipeAction(): Response
    {
        return $this->render('Recipe/show.html.twig');
    }

    /**
     * @Route("/recipe/add", name="add-recipe")
     */
    public function addAction(Request $request): Response
    {
        return $this->render('Recipe/add.html.twig');
    }
}
