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
}
