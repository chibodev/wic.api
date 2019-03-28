<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\ValueObject\RecipeType;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\RecipeRepository")
 * @ORM\Table(indexes={@ORM\Index(name="name_idx", columns={"name"})})
 */
class Recipe
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $uuid;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prep;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cook;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var Ingredient|null
     * @ORM\OneToMany(targetEntity="App\Infrastructure\Entity\Ingredient", mappedBy="recipe")
     */
    private $ingredient;

    /**
     * @var Direction|null
     * @ORM\OneToMany(targetEntity="App\Infrastructure\Entity\Direction", mappedBy="recipe")
     */
    private $direction;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $author;

    /**
     * @var RecipeType
     * @ORM\Embedded(class="App\Infrastructure\ValueObject\RecipeType", columnPrefix=false)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageLink;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageSource;

    /**
     * @throws Exception
     */
    public function __construct(
        string $name,
        ?int $prep,
        ?int $cook,
        ?Ingredient $ingredient,
        ?Direction $direction,
        ?string $author,
        RecipeType $type,
        string $imageLink,
        string $imageSource) {
        $this->name = $name;
        $this->ingredient = $ingredient;
        $uuid = Uuid::uuid4();
        $this->uuid = $uuid->toString();
        $this->createdAt = new DateTimeImmutable();
        $this->prep = $prep;
        $this->cook = $cook;
        $this->direction = $direction;
        $this->author = $author;
        $this->type = $type;
        $this->imageLink = $imageLink;
        $this->imageSource = $imageSource;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setIngredient(?Ingredient $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function getPrep(): ?int
    {
        return $this->prep;
    }

    public function getCook(): ?int
    {
        return $this->cook;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setPrep(int $prep): void
    {
        $this->prep = $prep;
    }

    public function setCook(int $cook): void
    {
        $this->cook = $cook;
    }

    public function getDirection(): ?Direction
    {
        return $this->direction;
    }

    public function setDirection(?Direction $direction): void
    {
        $this->direction = $direction;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $source): void
    {
        $this->author = $source;
    }

    public function getType(): RecipeType
    {
        return $this->type;
    }

    public function setImageLink(string $imageLink): void
    {
        $this->imageLink = $imageLink;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageSource(string $imageSource): void
    {
        $this->imageSource = $imageSource;
    }

    public function getImageSource(): ?string
    {
        return $this->imageSource;
    }
}