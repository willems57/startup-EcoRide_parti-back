<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $apiToken;

    /** @throws \Exception */
    public function __construct()
    {
        $this->apiToken = bin2hex(random_bytes(20));
        $this->voitures = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->trajetsfinis = new ArrayCollection();
    }

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Credits $credits = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Trajets $Trajets = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Trajetsedit $Tajetsedit = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Trajetsfini $Trajetsfini = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avis $Avis = null;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'User')]
    private Collection $voitures;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Avisvalidation $Avisvalidation = null;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'User', orphanRemoval: true)]
    private Collection $avis;

    /**
     * @var Collection<int, Trajetsfini>
     */
    #[ORM\ManyToMany(targetEntity: Trajetsfini::class, mappedBy: 'User')]
    private Collection $trajetsfinis;

    #[ORM\Column(length: 255)]
    private ?string $role = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): static
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getCredits(): ?Credits
    {
        return $this->credits;
    }

    public function setCredits(?Credits $credits): static
    {
        $this->credits = $credits;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getTrajets(): ?Trajets
    {
        return $this->Trajets;
    }

    public function setTrajets(?Trajets $Trajets): static
    {
        $this->Trajets = $Trajets;

        return $this;
    }

    public function getTajetsedit(): ?Trajetsedit
    {
        return $this->Tajetsedit;
    }

    public function setTajetsedit(?Trajetsedit $Tajetsedit): static
    {
        $this->Tajetsedit = $Tajetsedit;

        return $this;
    }

    public function getTrajetsfini(): ?Trajetsfini
    {
        return $this->Trajetsfini;
    }

    public function setTrajetsfini(?Trajetsfini $Trajetsfini): static
    {
        $this->Trajetsfini = $Trajetsfini;

        return $this;
    }

    public function getAvis(): ?Avis
    {
        return $this->Avis;
    }

    public function setAvis(Avis $Avis): static
    {
        $this->Avis = $Avis;

        return $this;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
            $voiture->setUser($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getUser() === $this) {
                $voiture->setUser(null);
            }
        }

        return $this;
    }

    public function getAvisvalidation(): ?Avisvalidation
    {
        return $this->Avisvalidation;
    }

    public function setAvisvalidation(?Avisvalidation $Avisvalidation): static
    {
        $this->Avisvalidation = $Avisvalidation;

        return $this;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setUser($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUser() === $this) {
                $avi->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trajetsfini>
     */
    public function getTrajetsfinis(): Collection
    {
        return $this->trajetsfinis;
    }

    public function addTrajetsfini(Trajetsfini $trajetsfini): static
    {
        if (!$this->trajetsfinis->contains($trajetsfini)) {
            $this->trajetsfinis->add($trajetsfini);
            $trajetsfini->addUser($this);
        }

        return $this;
    }

    public function removeTrajetsfini(Trajetsfini $trajetsfini): static
    {
        if ($this->trajetsfinis->removeElement($trajetsfini)) {
            $trajetsfini->removeUser($this);
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
}
