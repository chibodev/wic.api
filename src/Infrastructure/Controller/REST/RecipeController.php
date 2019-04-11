<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\REST;

use App\Infrastructure\DTO\Request\MealContent;
use App\Infrastructure\DTO\Response\NotFound;
use App\Infrastructure\DTO\Response\Recipe;
use App\Infrastructure\DTO\Response\RecipeShort;
use App\Infrastructure\PublicInterface\RecipeView;
use App\Infrastructure\Security\ApiUser;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api")
 */
class RecipeController extends AbstractFOSRestController
{
    private $recipeView;
    private $apiUserService;

    public function __construct(RecipeView $recipeView, ApiUser $apiUserService)
    {
        $this->recipeView = $recipeView;
        $this->apiUserService = $apiUserService;
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
     * @SWG\Response(
     *     response=400,
     *     description="Invalid data supplied",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=NotFound::class)
     *     )
     * )
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
        $responseCode = $recipe instanceof NotFound ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;

        return $this->handleView(View::create($recipe, $responseCode));
    }

    /**
     * @Route(path="/get/recipe", methods={"POST"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Successful retrieval of recipes off a specific search term",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=RecipeShort::class)
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No recipe found for search term",
     *     @SWG\Schema(
     *         type="object",
     *         ref=@Model(type=NotFound::class)
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
     * @SWG\Parameter(
     *     name="X-API",
     *     in="header",
     *     type="string",
     *     description="The api key",
     * )
     * @ParamConverter("content", converter="fos_rest.request_body")
     * @throws Exception
     */
    public function recipeSearchAction(MealContent $content, Request $request): Response
    {
        if (!$this->apiUserService->verifyAccess($request->headers->get('X-API'))) {
            return $this->handleView(View::create(null, Response::HTTP_UNAUTHORIZED));
        }

        $recipe = $this->recipeView->getRecipeByMealContent($content->getMealContent());

        $responseCode = $recipe instanceof NotFound ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        return $this->handleView(View::create($recipe, $responseCode));
    }

}
