<?php

namespace App\Entity;

use App\Repository\TrajetseditRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetseditRepository::class)]
class Trajetsedit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $voiture = null;

    #[ORM\Column(length: 255)]
    private ?string $fumeur = null;

    #[ORM\Column(length: 255)]
    private ?string $annimaux = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column]
    private ?int $place = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager5 = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $Voiture = null;

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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getVoiture(): ?string
    {
        return $this->voiture;
    }

    public function setVoiture(string $voiture): static
    {
        $this->voiture = $voiture;

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

    public function getPassager1(): ?string
    {
        return $this->passager1;
    }

    public function setPassager1(?string $passager1): static
    {
        $this->passager1 = $passager1;

        return $this;
    }

    public function getPassager2(): ?string
    {
        return $this->passager2;
    }

    public function setPassager2(?string $passager2): static
    {
        $this->passager2 = $passager2;

        return $this;
    }

    public function getPassager3(): ?string
    {
        return $this->passager3;
    }

    public function setPassager3(?string $passager3): static
    {
        $this->passager3 = $passager3;

        return $this;
    }

    public function getPassager4(): ?string
    {
        return $this->passager4;
    }

    public function setPassager4(?string $passager4): static
    {
        $this->passager4 = $passager4;

        return $this;
    }

    public function getPassager5(): ?string
    {
        return $this->passager5;
    }

    public function setPassager5(?string $passager5): static
    {
        $this->passager5 = $passager5;

        return $this;
    }
}
