<?php

declare(strict_types=1);

namespace App\Infrastructure\Tests\Unit\Service;

use App\EntityInterface\RecipeInterface as RecipeEntityInterface;
use App\Infrastructure\Entity\Recipe;
use App\Infrastructure\Entity\Unknown;
use App\Infrastructure\PublicInterface\DirectionRepositoryInterface;
use App\Infrastructure\PublicInterface\DTO\DirectionInterface;
use App\Infrastructure\PublicInterface\DTO\IngredientInterface;
use App\Infrastructure\PublicInterface\DTO\NotFoundInterface;
use App\Infrastructure\PublicInterface\DTO\RecipeInterface;
use App\Infrastructure\PublicInterface\DTO\RecipeShortInterface;
use App\Infrastructure\PublicInterface\RecipeView;
use App\Infrastructure\Repository\DirectionRepository;
use App\Infrastructure\Repository\IngredientRepository;
use App\Infrastructure\Repository\RecipeRepository;
use App\Infrastructure\Repository\UnknownRepository;
use App\Infrastructure\Service\RecipeViewService;
use App\Infrastructure\ValueObject\RecipeType;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;

class RecipeViewServiceTest extends TestCase
{
    /** @var NotFoundInterface|ObjectProphecy */
    private $notFound;
    /** @var RecipeShortInterface|ObjectProphecy */
    private $recipeShort;
    /** @var RecipeInterface|ObjectProphecy */
    private $recipeDto;
    /** @var RecipeRepository|ObjectProphecy */
    private $recipeRepo;
    /** @var UnknownRepository|ObjectProphecy */
    private $unknownRepo;
    /** @var IngredientRepository|ObjectProphecy */
    private $ingredientRepo;
    /** @var DirectionRepositoryInterface|ObjectProphecy */
    private $directionRepo;
    /** @var LoggerInterface|ObjectProphecy */
    private $logger;
    /** @var RecipeView */
    private $subject;

    public function setUp()
    {
        parent::setUp();
        $this->recipeRepo = $this->prophesize(RecipeRepository::class);
        $this->unknownRepo = $this->prophesize(UnknownRepository::class);
        $this->ingredientRepo = $this->prophesize(IngredientRepository::class);
        $this->directionRepo = $this->prophesize(DirectionRepository::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->notFound = $this->prophesize(NotFoundInterface::class);
        $this->recipeShort = $this->prophesize(RecipeShortInterface::class);
        $this->recipeDto = $this->prophesize(RecipeInterface::class);

        $this->subject = new RecipeViewService($this->recipeRepo->reveal(), $this->unknownRepo->reveal(), $this->ingredientRepo->reveal(),
            $this->directionRepo->reveal(), $this->notFound->reveal(), $this->recipeShort->reveal(), $this->recipeDto->reveal(),
            $this->logger->reveal());
    }

    public function testMealContentUnknownAndNew(): void
    {
        $mealContent = 'content';

        $this->recipeRepo->findByMealContent([$mealContent])->shouldBeCalled()->willReturn(null);

        $this->unknownRepo->findOneBy(['term' => $mealContent])->shouldBeCalled()->willReturn(null);
        $this->unknownRepo->save(Argument::type(Unknown::class))->shouldBeCalled();

        $result = $this->subject->getRecipeByMealContent($mealContent);

        self::assertInstanceOf(NotFoundInterface::class, $result);
    }

    public function testMealContentUnknownAndExisting(): void
    {
        $mealContent = 'content';
        $unknown = $this->prophesize(Unknown::class);

        $this->recipeRepo->findByMealContent([$mealContent])->shouldBeCalled()->willReturn(null);

        $this->unknownRepo->findOneBy(['term' => $mealContent])->shouldBeCalled()->willReturn($unknown->reveal());
        $unknown->updateCounter()->shouldBeCalled();
        $this->unknownRepo->save(Argument::type(Unknown::class))->shouldBeCalled();

        $result = $this->subject->getRecipeByMealContent($mealContent);

        self::assertInstanceOf(NotFoundInterface::class, $result);
    }

    public function testMealContentByMealContentIsSuccessful(): void
    {
        $mealContent = 'content';

        $type = RecipeType::FOOD;

        $recipe = $this->prophesize(Recipe::class);
        $recipe->getUuid()->shouldBeCalled()->willReturn('uuid');
        $recipe->getName()->shouldBeCalled()->willReturn('recipe');
        $recipe->getPrep()->shouldBeCalled()->willReturn(10);
        $recipe->getCook()->shouldBeCalled()->willReturn(20);
        $recipe->getType()->shouldBeCalled()->willReturn($type);
        $recipe->getImageUrl()->shouldBeCalled()->willReturn('url');

        $this->recipeRepo->findByMealContent([$mealContent])->shouldBeCalled()->willReturn([$recipe->reveal()]);

        $this->unknownRepo->findOneBy(['term' => $mealContent])->shouldNotBeCalled();
        $this->unknownRepo->save(Argument::type(Unknown::class))->shouldNotBeCalled();

        $result = $this->subject->getRecipeByMealContent($mealContent);

        $this->recipeShort->getUuid()->willReturn('uuid');
        $this->recipeShort->getName()->willReturn('recipe');
        $this->recipeShort->getPrep()->willReturn(10);
        $this->recipeShort->getCook()->willReturn(20);
        $this->recipeShort->getType()->willReturn($type);
        $this->recipeShort->getImageUrl()->willReturn('url');

        self::assertIsArray($result);
        self::assertSame('uuid', $result[0]->getUuid());
        self::assertSame('recipe', $result[0]->getName());
        self::assertSame(10, $result[0]->getPrep());
        self::assertSame(20, $result[0]->getCook());
        self::assertSame(RecipeType::FOOD, $result[0]->getType());
        self::assertSame('url', $result[0]->getImageUrl());
    }


    public function testGetRecipeByUuidWithInvalidUuid(): void
    {
        $uuid = 'invalid-uuid';

        $this->recipeRepo->findOneBy(Argument::any())->shouldNotBeCalled();
        $result = $this->subject->getRecipeByUuid($uuid);

        self::assertInstanceOf(NotFoundInterface::class, $result);
    }

    public function testGetRecipeByUuidFails(): void
    {
        $uuid = 'fb09d733-be43-4ce3-a1df-e55796746738';

        $this->recipeRepo->findOneBy(Argument::any())->shouldBeCalled()->willReturn(null);
        $result = $this->subject->getRecipeByUuid($uuid);

        $this->directionRepo->findOneByRecipeForDto(Argument::any())->shouldNotBeCalled();
        $this->ingredientRepo->findOneByRecipeForDto(Argument::any())->shouldNotBeCalled();

        self::assertInstanceOf(NotFoundInterface::class, $result);
    }

    public function testGetRecipeByUuidSucceeds(): void
    {
        $type = RecipeType::BEVERAGE;
        $uuid = 'fb09d733-be43-4ce3-a1df-e55796746738';
        $direction = $this->prophesize(DirectionInterface::class);
        $ingredient = $this->prophesize(IngredientInterface::class);
        $recipe = $this->prophesize(RecipeEntityInterface::class);

        $recipe->getName()->shouldBeCalled()->willReturn('recipe');
        $recipe->getPrep()->shouldBeCalled()->willReturn(10);
        $recipe->getCook()->shouldBeCalled()->willReturn(20);
        $recipe->getType()->shouldBeCalled()->willReturn($type);
        $recipe->getImageUrl()->shouldBeCalled()->willReturn('url');
        $recipe->getImageSource()->shouldBeCalled()->willReturn('urlSource');
        $recipe->getAuthor()->shouldBeCalled()->willReturn('me');

        $direction->getDescription()->willReturn('description');
        $ingredient->getDescription()->willReturn('description');

        $this->recipeRepo->findOneBy(['uuid' => $uuid])->shouldBeCalled()->willReturn($recipe->reveal());

        $this->directionRepo->findOneByRecipeForDto($recipe->reveal())->shouldBeCalled()->willReturn([$direction->reveal()]);
        $this->ingredientRepo->findOneByRecipeForDto($recipe->reveal())->shouldBeCalled()->willReturn([$ingredient->reveal()]);

        $result = $this->subject->getRecipeByUuid($uuid);

        $this->recipeDto->getName()->willReturn('recipe');
        $this->recipeDto->getPrep()->willReturn(10);
        $this->recipeDto->getCook()->willReturn(20);
        $this->recipeDto->getType()->willReturn($type);
        $this->recipeDto->getImageUrl()->willReturn('url');
        $this->recipeDto->getImageSource()->willReturn('urlSource');
        $this->recipeDto->getAuthor()->willReturn('me');
        $this->recipeDto->getDirection()->willReturn([$direction->reveal()]);
        $this->recipeDto->getIngredient()->willReturn([$ingredient->reveal()]);

        self::assertInstanceOf(RecipeInterface::class, $result);
        self::assertSame('recipe', $result->getName());
        self::assertSame(10, $result->getPrep());
        self::assertSame(20, $result->getCook());
        self::assertSame(RecipeType::BEVERAGE, $result->getType());
        self::assertSame('url', $result->getImageUrl());
        self::assertSame('urlSource', $result->getImageSource());
        self::assertSame('me', $result->getAuthor());
        self::assertSame('description', $result->getDirection()[0]->getDescription());
        self::assertSame('description', $result->getIngredient()[0]->getDescription());

    }
}
