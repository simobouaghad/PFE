<?php

namespace App\Entity;

use App\Repository\ListnoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListnoteRepository::class)]
class Listnote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $cne;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'listnotes')]
    private $groupe;

    #[ORM\ManyToOne(targetEntity: Matire::class, inversedBy: 'listnotes')]
    private $matire;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ds1;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ds2;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ds3;

    #[ORM\Column(type: 'float', nullable: true)]
    private $total;

    #[ORM\ManyToOne(targetEntity: Session::class, inversedBy: 'listnotes')]
    private $session;

    #[ORM\Column(type: 'string', length: 255)]
    private $semestre;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ds4;

    #[ORM\Column(type: 'float', nullable: true)]
    private $activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCne(): ?string
    {
        return $this->cne;
    }

    public function setCne(string $cne): self
    {
        $this->cne = $cne;

        return $this;
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

    public function getMatire(): ?Matire
    {
        return $this->matire;
    }

    public function setMatire(?Matire $matire): self
    {
        $this->matire = $matire;

        return $this;
    }

    public function getDs1(): ?float
    {
        return $this->ds1;
    }

    public function setDs1(?float $ds1): self
    {
        $this->ds1 = $ds1;

        return $this;
    }

    public function getDs2(): ?float
    {
        return $this->ds2;
    }

    public function setDs2(?float $ds2): self
    {
        $this->ds2 = $ds2;

        return $this;
    }

    public function getDs3(): ?float
    {
        return $this->ds3;
    }

    public function setDs3(?float $ds3): self
    {
        $this->ds3 = $ds3;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getSemestre(): ?string
    {
        return $this->semestre;
    }

    public function setSemestre(string $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getDs4(): ?float
    {
        return $this->ds4;
    }

    public function setDs4(?float $ds4): self
    {
        $this->ds4 = $ds4;

        return $this;
    }

    public function getActivite(): ?float
    {
        return $this->activite;
    }

    public function setActivite(?float $activite): self
    {
        $this->activite = $activite;

        return $this;
    }
}
