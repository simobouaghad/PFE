<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'sales')]
    private $centre;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'sales')]
    private $ville;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: Calendaretude::class)]
    private $calendaretudes;

    public function __construct()
    {
        $this->calendaretudes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCentre(): ?Centre
    {
        return $this->centre;
    }

    public function setCentre(?Centre $centre): self
    {
        $this->centre = $centre;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function __toString() {
        return $this->nom;
    }

    /**
     * @return Collection<int, Calendaretude>
     */
    public function getCalendaretudes(): Collection
    {
        return $this->calendaretudes;
    }

    public function addCalendaretude(Calendaretude $calendaretude): self
    {
        if (!$this->calendaretudes->contains($calendaretude)) {
            $this->calendaretudes[] = $calendaretude;
            $calendaretude->setSale($this);
        }

        return $this;
    }

    public function removeCalendaretude(Calendaretude $calendaretude): self
    {
        if ($this->calendaretudes->removeElement($calendaretude)) {
            // set the owning side to null (unless already changed)
            if ($calendaretude->getSale() === $this) {
                $calendaretude->setSale(null);
            }
        }

        return $this;
    }
}
