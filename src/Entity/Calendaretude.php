<?php

namespace App\Entity;

use App\Repository\CalendaretudeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendaretudeRepository::class)]
class Calendaretude
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'calendaretudes')]
    private $groupe;

    #[ORM\ManyToOne(targetEntity: Sale::class, inversedBy: 'calendaretudes')]
    private $sale;

    #[ORM\ManyToOne(targetEntity: Matire::class, inversedBy: 'calendaretudes')]
    private $matire;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'calendaretudes')]
    private $professeur;

    #[ORM\Column(type: 'datetime')]
    private $start;

    #[ORM\Column(type: 'datetime')]
    private $end;

    #[ORM\Column(type: 'string', length: 7)]
    private $background_color;

    #[ORM\Column(type: 'string', length: 7)]
    private $border_color;

    #[ORM\Column(type: 'string', length: 7)]
    private $text_color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    public function getMatire(): ?Matire
    {
        return $this->matire;
    }

    public function setMatire(?Matire $matire): self
    {
        $this->matire = $matire;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): self
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->border_color;
    }

    public function setBorderColor(string $border_color): self
    {
        $this->border_color = $border_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(string $text_color): self
    {
        $this->text_color = $text_color;

        return $this;
    }
}
