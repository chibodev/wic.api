<?php

namespace App\Recipe\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Recipe\Repository\DirectionRepository")
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
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var Recipe
     * @ORM\ManyToOne(targetEntity="App\Recipe\Entity\Recipe", inversedBy="direction")
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

    public function setRecipe(Recipe $recipe): void
    {
        $this->recipe = $recipe;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    /*
     * Explicitly for EasyAdmin
     */
    public function __toString()
    {
        return sprintf('Id #%d: %s',$this->getId(), $this->getDescription());
    }
}
