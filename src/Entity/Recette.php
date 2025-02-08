<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recettes.show','plats.show','plats.create'])]
    private ?int $id = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    #[Groups(['recettes.create','recettes.show','plats.show'])]
    private Collection $ingredients;

    #[ORM\OneToOne(mappedBy: 'Recette', cascade: ['persist', 'remove'])]
    private ?Plat $plat = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): static
    {
        // unset the owning side of the relation if necessary
        if ($plat === null && $this->plat !== null) {
            $this->plat->setRecette(null);
        }

        // set the owning side of the relation if necessary
        if ($plat !== null && $plat->getRecette() !== $this) {
            $plat->setRecette($this);
        }

        $this->plat = $plat;

        return $this;
    }
}
