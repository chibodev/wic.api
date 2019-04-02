<?php

namespace App\Infrastructure\Entity;

use App\EntityInterface\IngredientInterface;
use App\EntityInterface\RecipeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\IngredientRepository")
 * @ORM\Table(indexes={@ORM\Index(name="description_idx", columns={"description"})})
 */
class Ingredient implements IngredientInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $description;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantity;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $unit;

    /**
     * @var RecipeInterface
     * @ORM\ManyToOne(targetEntity="App\EntityInterface\RecipeInterface", inversedBy="ingredient")
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

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): void
    {
        $this->unit = $unit;
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
        return sprintf('Id #%d: %s %s%s',$this->getId(), $this->getDescription(), $this->getQuantity(), $this->unit);
    }
}
