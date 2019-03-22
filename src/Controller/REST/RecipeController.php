<?php

declare(strict_types=1);

namespace App\Controller\REST;

use App\DTO\Request\MealContent;
use App\DTO\Response\RecipeShort;
use App\DTO\Response\Recipe;
use App\Service\RecipeView;
use Exception;
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
     *
     * @SWG\Response(
     *     response=200,
     *     description="The endpoint for getting recipes off a specific search term",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=Recipe::class)
     *     )
     * )
     *
     * @SWG\Parameter(
     *     name="uuid",
     *     in="path",
     *     type="string",
     *     description="The recipe uuid",
     *     default="f88808ca-310d-40d8-8042-2628af9fbf06"
     * )
     *
     * @throws Exception
     */
    public function getRecipeAction(string $uuid): Response
    {
        $recipe = $this->recipeView->getRecipeByUuid($uuid);

        return $this->handleView(View::create($recipe, Response::HTTP_OK));
    }

    /**
     * @Route(path="/get/recipe", methods={"POST"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="The endpoint for getting recipes off a specific search term",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=RecipeShort::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="json",
     *     description="The search term parameter(s)",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=MealContent::class)
     *     )
     * )
     * @ParamConverter("content", converter="fos_rest.request_body")
     * @throws Exception
     */
    public function recipeSearchAction(MealContent $content): Response
    {
        $recipe = $this->recipeView->getRecipeByMealContent($content->getMealContent());

        return $this->handleView(View::create($recipe), Response::HTTP_OK);
    }

}
