<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: SousCategory::class, inversedBy: 'groupes')]
    private $souscategory;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'groupes')]
    private $centre;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'groupes')]
    private $category;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Payement::class)]
    private $payements;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Calendaretude::class)]
    private $calendaretudes;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Listnote::class)]
    private $listnotes;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: Planning::class)]
    private $plannings;



    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->payiements = new ArrayCollection();
        $this->payements = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->calendaretudes = new ArrayCollection();
        $this->gestionmatires = new ArrayCollection();
        $this->listnotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSouscategory(): ?SousCategory
    {
        return $this->souscategory;
    }

    public function setSouscategory(?SousCategory $souscategory): self
    {
        $this->souscategory = $souscategory;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setGroupe($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getGroupe() === $this) {
                $etudiant->setGroupe(null);
            }
        }

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Payement>
     */
    public function getPayements(): Collection
    {
        return $this->payements;
    }

    public function addPayement(Payement $payement): self
    {
        if (!$this->payements->contains($payement)) {
            $this->payements[] = $payement;
            $payement->setGroupe($this);
        }

        return $this;
    }

    public function removePayement(Payement $payement): self
    {
        if ($this->payements->removeElement($payement)) {
            // set the owning side to null (unless already changed)
            if ($payement->getGroupe() === $this) {
                $payement->setGroupe(null);
            }
        }

        return $this;
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
            $calendaretude->setGroupe($this);
        }

        return $this;
    }

    public function removeCalendaretude(Calendaretude $calendaretude): self
    {
        if ($this->calendaretudes->removeElement($calendaretude)) {
            // set the owning side to null (unless already changed)
            if ($calendaretude->getGroupe() === $this) {
                $calendaretude->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gestionmatire>
     */
    public function getGestionmatires(): Collection
    {
        return $this->gestionmatires;
    }

    public function addGestionmatire(Gestionmatire $gestionmatire): self
    {
        if (!$this->gestionmatires->contains($gestionmatire)) {
            $this->gestionmatires[] = $gestionmatire;
            $gestionmatire->setGroupe($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getGroupe() === $this) {
                $gestionmatire->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Listnote>
     */
    public function getListnotes(): Collection
    {
        return $this->listnotes;
    }

    public function addListnote(Listnote $listnote): self
    {
        if (!$this->listnotes->contains($listnote)) {
            $this->listnotes[] = $listnote;
            $listnote->setGroupe($this);
        }

        return $this;
    }

    public function removeListnote(Listnote $listnote): self
    {
        if ($this->listnotes->removeElement($listnote)) {
            // set the owning side to null (unless already changed)
            if ($listnote->getGroupe() === $this) {
                $listnote->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings[] = $planning;
            $planning->setGroupe($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getGroupe() === $this) {
                $planning->setGroupe(null);
            }
        }

        return $this;
    }


}
