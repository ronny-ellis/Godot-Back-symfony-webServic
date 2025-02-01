<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'recette', cascade: ['persist', 'remove'])]
    private ?Plat $plat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(Plat $plat): static
    {
        // set the owning side of the relation if necessary
        if ($plat->getRecette() !== $this) {
            $plat->setRecette($this);
        }

        $this->plat = $plat;

        return $this;
    }
}
