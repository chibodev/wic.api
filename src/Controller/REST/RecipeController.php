<?php

declare(strict_types=1);

namespace App\Controller\REST;

use App\DTO\Request\MealContent;
use App\DTO\Response\Recipe;
use App\Service\RecipeView;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * @Route("api")
 */
class RecipeController extends AbstractFOSRestController
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
    private $recipeView;

    public function __construct(RecipeView $recipeView)
    {
        $this->recipeView = $recipeView;
    }

    /**
     * @Route(path="/get/recipe/{uuid}", methods={"GET"})
     */
    public function recipeAction(string $uuid): Response
    {
        //TODO: call service to takes care of retrieving data based on its uuid
        return $this->handleView(View::create(null, Response::HTTP_OK));
    }

    /**
     * @Route(path="/get/recipe", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="The endpoint for successful save",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=Recipe::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="json",
     *     description="The Sme parameters",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=MealContent::class)
     *     )
     * )
     * @ParamConverter("content", converter="fos_rest.request_body")
     */
    public function recipeSearchAction(MealContent $content): Response
    {
        //TODO: call service to takes care of retrieving data based on its uuid

        return $this->handleView(View::create($this->recipeView->getRecipeByMealContent($content->getContent()), Response::HTTP_OK));
    }

}
