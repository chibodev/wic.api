<?php

namespace App\Recipe\Entity;

use App\Recipe\ValueObject\RecipeType;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Recipe\Repository\RecipeRepository")
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
     * @var Ingredient|Collection
     * @ORM\OneToMany(targetEntity="App\Recipe\Entity\Ingredient", mappedBy="recipe")
     */
    private $ingredient;

    /**
     * @var Direction|Collection
     * @ORM\OneToMany(targetEntity="App\Recipe\Entity\Direction", mappedBy="recipe")
     */
    private $direction;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $author;

    /**
     * @var RecipeType
     * @ORM\Embedded(class="App\Recipe\ValueObject\RecipeType", columnPrefix=false)
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
        $this->type = new RecipeType(RecipeType::INCONCLUSIVE);
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

    public function setIngredient(?Ingredient $ingredient): void
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

    public function setDirection(?Direction $direction): void
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

    public function setType(?RecipeType $type): void
    {
        $this->type = $type;
    }

    public function getType(): RecipeType
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

    /*
     * Explicitly for EasyAdmin
     */
    public function __toString(): string
    {
        return sprintf('Recipe #%d: %s',$this->getId(), $this->getName());
    }
}
