<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateimat = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $fumeur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $annimaux = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $place = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDateimat(): ?\DateTimeInterface
    {
        return $this->dateimat;
    }

    public function setDateimat(\DateTimeInterface $dateimat): static
    {
        $this->dateimat = $dateimat;

        return $this;
    }

    public function getFumeur(): ?string
    {
        return $this->fumeur;
    }

    public function setFumeur(string $fumeur): static
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    public function getAnnimaux(): ?string
    {
        return $this->annimaux;
    }

    public function setAnnimaux(string $annimaux): static
    {
        $this->annimaux = $annimaux;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
