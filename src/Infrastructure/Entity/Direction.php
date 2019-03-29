<?php

namespace App\Infrastructure\Entity;

use App\EntityInterface\DirectionInterface;
use App\EntityInterface\RecipeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\DirectionRepository")
 */
class Direction implements DirectionInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var RecipeInterface
     * @ORM\ManyToOne(targetEntity="App\EntityInterface\RecipeInterface", inversedBy="direction")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", nullable=false)
     */
    private $recipe;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setRecipe(RecipeInterface $recipe): void
    {
        $this->recipe = $recipe;
    }

    public function getRecipe(): ?RecipeInterface
    {
        return $this->recipe;
    }

    public function __toString() {

        return (string)$this->getId();
    }
}
