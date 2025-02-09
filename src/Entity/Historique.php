<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HistoriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
//#[ApiResource]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['historiques.show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['historiques.show','historiques.create'])]
    private ?string $variableType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['historiques.show'])]
    private ?\DateTimeInterface $dateUpdate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['historiques.show'])]
    private ?\DateTimeInterface $dateAjout = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariableType(): ?string
    {
        return $this->variableType;
    }

    public function setVariableType(string $variableType): static
    {
        $this->variableType = $variableType;

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

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }
}
