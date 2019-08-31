<?php

declare(strict_types=1);

namespace App\Recipe\Controller\REST;

use App\Recipe\DTO\Request\MealContent;
use App\Recipe\DTO\Response\NotFound;
use App\Recipe\DTO\Response\Recipe;
use App\Recipe\DTO\Response\RecipeShort;
use App\Recipe\PublicInterface\RecipeView;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/v1")
 */
class RecipeController extends AbstractFOSRestController
{
    private $recipeView;

    public function __construct(RecipeView $recipeView)
    {
        $this->recipeView = $recipeView;
    }

    /**
     * @Route(path="/recipes/{uuid}", methods={"GET"})
     *
     * @SWG\Parameter(
     *     name="X-AUTH-TOKEN",
     *     in="header",
     *     type="string",
     *     description="The api key",
     * )
     * @SWG\Parameter(
     *     name="uuid",
     *     in="path",
     *     type="string",
     *     description="The recipe uuid",
     *     default="f88808ca-310d-40d8-8042-2628af9fbf06"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="The retrieval of a single recipe off a UUID was successful",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=Recipe::class)
     *     )
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="The authentication header is missing",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Access is not authorized with requested token",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="There is no recipe associated with provided UUID",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=NotFound::class)
     *     )
     * )
     *
     * @throws Exception
     */
    public function getRecipeAction(string $uuid): Response
    {
        $recipe = $this->recipeView->getRecipeByUuid($uuid);
        $responseCode = $recipe instanceof NotFound ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        return $this->handleView(View::create($recipe, $responseCode));
    }

    /**
     * @Route(path="/recipes/search", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="X-AUTH-TOKEN",
     *     in="header",
     *     type="string",
     *     description="The api key",
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
     * @SWG\Response(
     *     response=200,
     *     description="The retrieval of recipes off a specific search term was successful",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=RecipeShort::class)
     *     )
     * )
     * @SWG\Response(
     *     response=401,
     *     description="The authentication header is missing",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Access is not authorized with requested token",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No recipe found for search term at the moment",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=NotFound::class)
     *     )
     * )
     *
     * @ParamConverter("content", converter="fos_rest.request_body")
     * @throws Exception
     */
    public function recipeSearchAction(MealContent $content): Response
    {
        $recipe = $this->recipeView->getRecipeByMealContent($content->getMealContent());

        $responseCode = $recipe instanceof NotFound ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        return $this->handleView(View::create($recipe, $responseCode));
    }
}
