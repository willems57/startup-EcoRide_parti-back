<?php

namespace App\Entity;

use App\Repository\CreditsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditsRepository::class)]
class Credits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $credits = null;

    #[ORM\OneToOne(mappedBy: 'credits', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): static
    {
        $this->credits = $credits;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setCredits(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCredits() !== $this) {
            $user->setCredits($this);
        }

        $this->user = $user;

        return $this;
    }
}
