<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipe/list", name="recipe")
     */
    public function recipeAction(): Response
    {
        return $this->render('Recipe/show.html.twig');
    }

    /**
     * @Route("/recipe/add", name="add-recipe")
     */
    public function addAction(): Response
    {
        return $this->render('Recipe/show.html.twig');
    }
}
