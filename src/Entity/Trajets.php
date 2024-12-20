<?php

namespace App\Entity;

use App\Repository\TrajetsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetsRepository::class)]
class Trajets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $depart = null;

    #[ORM\Column(length: 255)]
    private ?string $arrive = null;

    #[ORM\Column(length: 255)]
    private ?string $conducteur = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private array $datetime = [];

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(length: 255)]
    private ?string $voiture = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255)]
    private ?string $fumeur = null;

    #[ORM\Column(length: 255)]
    private ?string $annimaux = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $places = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmailInput1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmailInput2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmailInput3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmailInput4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passager5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmailInput5 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): static
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrive(): ?string
    {
        return $this->arrive;
    }

    public function setArrive(string $arrive): static
    {
        $this->arrive = $arrive;

        return $this;
    }

    public function getConducteur(): ?string
    {
        return $this->conducteur;
    }

    public function setConducteur(string $conducteur): static
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    public function getDatetime(): array
    {
        return $this->datetime;
    }

    public function setDatetime(array $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

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

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

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

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): static
    {
        $this->places = $places;

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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

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

    public function getEmailInput1(): ?string
    {
        return $this->EmailInput1;
    }

    public function setEmailInput1(?string $EmailInput1): static
    {
        $this->EmailInput1 = $EmailInput1;

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

    public function getEmailInput2(): ?string
    {
        return $this->EmailInput2;
    }

    public function setEmailInput2(?string $EmailInput2): static
    {
        $this->EmailInput2 = $EmailInput2;

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

    public function getEmailInput3(): ?string
    {
        return $this->EmailInput3;
    }

    public function setEmailInput3(?string $EmailInput3): static
    {
        $this->EmailInput3 = $EmailInput3;

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

    public function getEmailInput4(): ?string
    {
        return $this->EmailInput4;
    }

    public function setEmailInput4(?string $EmailInput4): static
    {
        $this->EmailInput4 = $EmailInput4;

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

    public function getEmailInput5(): ?string
    {
        return $this->EmailInput5;
    }

    public function setEmailInput5(?string $EmailInput5): static
    {
        $this->EmailInput5 = $EmailInput5;

        return $this;
    }
}
