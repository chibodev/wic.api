<?php

namespace App\Infrastructure\Entity;

use App\EntityInterface\DirectionInterface;
use App\EntityInterface\IngredientInterface;
use App\EntityInterface\RecipeInterface;
use App\Infrastructure\ValueObject\RecipeType;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\RecipeRepository")
 * @ORM\Table(indexes={@ORM\Index(name="name_idx", columns={"name"})})
 */
class Recipe implements RecipeInterface
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
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(0)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prep;

    /**
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(0)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cook;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var IngredientInterface|Collection
     * @ORM\OneToMany(targetEntity="App\EntityInterface\IngredientInterface", mappedBy="recipe")
     */
    private $ingredient;

    /**
     * @var DirectionInterface|Collection
     * @ORM\OneToMany(targetEntity="App\EntityInterface\DirectionInterface", mappedBy="recipe")
     */
    private $direction;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @Assert\Url
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageUrl;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageSource;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $approved = 0;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $keto = 0;

    /**
     * @throws Exception
     */
    public function __construct() {
        $uuid = Uuid::uuid4();
        $this->uuid = $uuid->toString();
        $this->createdAt = new DateTime();
        $recipeType = new RecipeType(RecipeType::INCONCLUSIVE);
        $this->type = $recipeType->getValue();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setIngredient(?IngredientInterface $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    public function getIngredient()
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setPrep(?int $prep): void
    {
        $this->prep = $prep;
    }

    public function setCook(?int $cook): void
    {
        $this->cook = $cook;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection(?DirectionInterface $direction): void
    {
        $this->direction = $direction;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $source): void
    {
        $this->author = $source;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageSource(?string $imageSource): void
    {
        $this->imageSource = $imageSource;
    }

    public function getImageSource(): ?string
    {
        return $this->imageSource;
    }

    public function isKeto(): bool
    {
        return $this->keto;
    }

    public function setKeto(bool $keto): void
    {
        $this->keto = $keto;
    }

    public function isApproved(): bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): void
    {
        $this->approved = $approved;
    }

    public function __toString(): string
    {
        return sprintf('Recipe #%d: %s',$this->getId(), $this->getName());
    }
}
