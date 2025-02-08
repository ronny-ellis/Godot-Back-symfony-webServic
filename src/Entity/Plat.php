<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['plats.show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plats.show','plats.create'])]
    private ?string $nom = null;

    #[ORM\OneToOne(inversedBy: 'plat', cascade: ['persist', 'remove'])]
    #[Groups(['plats.show','plats.create'])]
    private ?Recette $Recette = null;

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

    public function getRecette(): ?Recette
    {
        return $this->Recette;
    }

    public function setRecette(?Recette $Recette): static
    {
        $this->Recette = $Recette;

        return $this;
    }
}
