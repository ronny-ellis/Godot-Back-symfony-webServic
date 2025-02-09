<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ingredients.show','recettes.create','recettes.show','plats.show','commandes.show','stocks.shows'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ingredients.show','ingredients.create','recettes.show','plats.show','commandes.show','stocks.show'])]
    private ?string $nom = null;

    #[ORM\OneToOne(mappedBy: 'ingredient', cascade: ['persist', 'remove'])]
    #[Groups(['ingredients.show'])]
    private ?Stock $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): static
    {
        // set the owning side of the relation if necessary
        if ($stock->getIngredient() !== $this) {
            $stock->setIngredient($this);
        }

        $this->stock = $stock;

        return $this;
    }
}
