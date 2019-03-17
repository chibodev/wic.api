<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Ingredient", mappedBy="recipe")
     */
    private $ingredient;

    /**
     * @var Direction|null
     * @ORM\OneToMany(targetEntity="App\Entity\Direction", mappedBy="recipe")
     */
    private $direction;

    /**
     * @throws Exception
     */
    public function __construct(string $name, ?int $prep, ?int $cook, ?Ingredient $ingredient, ?Direction $direction)
    {
        $this->name = $name;
        $this->ingredient = $ingredient;
        $uuid = Uuid::uuid4();
        $this->uuid = $uuid->toString();
        $this->createdAt = new DateTimeImmutable();
        $this->prep = $prep;
        $this->cook = $cook;
        $this->direction = $direction;
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
}
