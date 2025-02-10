<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['commandes.show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['commandes.show','commandes.create'])]
    private ?string $idUser = null;

    /**
     * @var Collection<int, Plat>
     */
    #[ORM\ManyToMany(targetEntity: Plat::class, inversedBy: 'commandes')]
    #[Groups(['commandes.show','commandes.create'])]
    private Collection $plat;

    #[ORM\Column]
    #[Groups(['commandes.show','commandes.create','commandes.update'])]
    private ?bool $estRecu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['commandes.show'])]
    private ?\DateTimeInterface $dateUpdate = null;

    #[ORM\Column]
    #[Groups(['commandes.show'],['commandes.creates'])]
    private ?int $quantite = null;

    #[ORM\Column]
    #[Groups(['commandes.show'],['commandes.creates'])]
    private ?bool $estTermine = null;

    public function __construct()
    {
        $this->plat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?string
    {
        return $this->idUser;
    }

    public function setIdUser(string $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPlat(): Collection
    {
        return $this->plat;
    }

    public function addPlat(Plat $plat): static
    {
        if (!$this->plat->contains($plat)) {
            $this->plat->add($plat);
        }

        return $this;
    }

    public function removePlat(Plat $plat): static
    {
        $this->plat->removeElement($plat);

        return $this;
    }

    public function isEstRecu(): ?bool
    {
        return $this->estRecu;
    }

    public function setEstRecu(bool $estRecu): static
    {
        $this->estRecu = $estRecu;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): static
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function isEstTermine(): ?bool
    {
        return $this->estTermine;
    }

    public function setEstTermine(bool $estTermine): static
    {
        $this->estTermine = $estTermine;

        return $this;
    }
}
