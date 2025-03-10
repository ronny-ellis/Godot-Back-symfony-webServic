<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['plats.show','commandes.show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plats.show','plats.create','commandes.show'])]
    private ?string $nom = null;

    #[ORM\OneToOne(inversedBy: 'plat', cascade: ['persist', 'remove'])]
    #[Groups(['plats.show','plats.create','commandes.show'])]
    private ?Recette $Recette = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'plat')]
    private Collection $commandes;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    #[Groups(['plats.show','plats.create','commandes.show'])]
    private ?string $prix = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Groups(['plats.show','plats.create','commandes.show'])]
    private ?\DateTimeInterface $tempsDeCuisson = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addPlat($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removePlat($this);
        }

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTempsDeCuisson(): ?\DateTimeInterface
    {
        return $this->tempsDeCuisson;
    }

    public function setTempsDeCuisson(?\DateTimeInterface $tempsDeCuisson): static
    {
        $this->tempsDeCuisson = $tempsDeCuisson;

        return $this;
    }
}
