<?php

namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\DirectionRepository")
 */
class Direction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var Recipe
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Entity\Recipe", inversedBy="direction")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", nullable=false)
     */
    private $recipe;

    public function __construct(string $description, Recipe $recipe)
    {
        $this->description = $description;
        $this->recipe = $recipe;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }
}
