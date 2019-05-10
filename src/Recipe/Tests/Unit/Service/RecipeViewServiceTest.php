<?php

declare(strict_types=1);

namespace App\Recipe\Tests\Unit\Service;

use App\EntityInterface\RecipeInterface as RecipeEntityInterface;
use App\Recipe\DTO\Response\RecipeShort;
use App\Recipe\Entity\Recipe;
use App\Recipe\Entity\Unknown;
use App\Recipe\PublicInterface\DirectionRepositoryInterface;
use App\Recipe\PublicInterface\DTO\DirectionInterface;
use App\Recipe\PublicInterface\DTO\IngredientInterface;
use App\Recipe\PublicInterface\DTO\NotFoundInterface;
use App\Recipe\PublicInterface\DTO\RecipeInterface;
use App\Recipe\PublicInterface\RecipeView;
use App\Recipe\Repository\DirectionRepository;
use App\Recipe\Repository\IngredientRepository;
use App\Recipe\Repository\RecipeRepository;
use App\Recipe\Repository\UnknownRepository;
use App\Recipe\Service\RecipeViewService;
use App\Recipe\ValueObject\RecipeType;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use RuntimeException;

class RecipeViewServiceTest extends TestCase
{
    /** @var NotFoundInterface|ObjectProphecy */
    private $notFound;
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
        $this->recipeDto = $this->prophesize(RecipeInterface::class);

        $this->subject = new RecipeViewService($this->recipeRepo->reveal(), $this->unknownRepo->reveal(), $this->ingredientRepo->reveal(),
            $this->directionRepo->reveal(), $this->notFound->reveal(), $this->recipeDto->reveal(),
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

        $type = new RecipeType(RecipeType::FOOD);

        $recipe = $this->prophesize(Recipe::class);
        $recipeShort = $this->prophesize(RecipeShort::class);

        $recipe->getUuid()->shouldBeCalled()->willReturn('uuid');
        $recipe->getName()->shouldBeCalled()->willReturn('recipe');
        $recipe->getPrep()->shouldBeCalled()->willReturn(10);
        $recipe->getCook()->shouldBeCalled()->willReturn(20);
        $recipe->getType()->shouldBeCalled()->willReturn($type);
        $recipe->getImageUrl()->shouldBeCalled()->willReturn('url');
        $recipe->isKeto()->shouldBeCalled()->willReturn(true);

        $this->recipeRepo->findByMealContent([$mealContent])->shouldBeCalled()->willReturn([$recipe->reveal()]);

        $this->unknownRepo->findOneBy(['term' => $mealContent])->shouldNotBeCalled();
        $this->unknownRepo->save(Argument::type(Unknown::class))->shouldNotBeCalled();

        $result = $this->subject->getRecipeByMealContent($mealContent);

        $recipeShort->getUuid()->willReturn('uuid');
        $recipeShort->getName()->willReturn('recipe');
        $recipeShort->getPrep()->willReturn(10);
        $recipeShort->getCook()->willReturn(20);
        $recipeShort->getType()->willReturn($type);
        $recipeShort->getImageUrl()->willReturn('url');
        $recipeShort->isKeto()->willReturn(true);

        self::assertIsArray($result);
        self::assertSame('uuid', $result[0]->getUuid());
        self::assertSame('recipe', $result[0]->getName());
        self::assertSame(10, $result[0]->getPrep());
        self::assertSame(20, $result[0]->getCook());
        self::assertSame(RecipeType::FOOD, $result[0]->getType());
        self::assertSame('url', $result[0]->getImageUrl());
        self::assertTrue($result[0]->isKeto());
    }


    public function testGetRecipeByUuidWithInvalidUuid(): void
    {
        $uuid = 'invalid-uuid';

        $this->recipeRepo->findOneBy(Argument::any())->shouldNotBeCalled();

        $this->expectException(RuntimeException::class);

        $this->subject->getRecipeByUuid($uuid);
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
        $type = new RecipeType(RecipeType::BEVERAGE);
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
        $recipe->isKeto()->shouldBeCalled()->willReturn(false);

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
        $this->recipeDto->isKeto()->willReturn(false);

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
        self::assertFalse($result->isKeto());
    }
}
