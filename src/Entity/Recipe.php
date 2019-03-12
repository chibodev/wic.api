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
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @var Ingredient|null
     * @ORM\OneToOne(targetEntity="App\Entity\Ingredient", mappedBy="recipe")
     */
    private $ingredient;

    /**
     * @throws Exception
     */
    public function __construct(string $name, ?Ingredient $ingredient)
    {
        $this->name = $name;
        $this->ingredient = $ingredient;
        $uuid = Uuid::uuid4();
        $this->uuid = $uuid->toString();
        $this->createdAt = new DateTimeImmutable();
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
}
