<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Payement::class)]
    private $payements;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Listnote::class)]
    private $listnotes;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Semestre::class)]
    private $semestres;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->payements = new ArrayCollection();
        $this->listnotes = new ArrayCollection();
        $this->gestionmatires = new ArrayCollection();
        $this->semestres = new ArrayCollection();
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
            $etudiant->setAnnee($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getAnnee() === $this) {
                $etudiant->setAnnee(null);
            }
        }

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
            $payement->setSession($this);
        }

        return $this;
    }

    public function removePayement(Payement $payement): self
    {
        if ($this->payements->removeElement($payement)) {
            // set the owning side to null (unless already changed)
            if ($payement->getSession() === $this) {
                $payement->setSession(null);
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
            $listnote->setSession($this);
        }

        return $this;
    }

    public function removeListnote(Listnote $listnote): self
    {
        if ($this->listnotes->removeElement($listnote)) {
            // set the owning side to null (unless already changed)
            if ($listnote->getSession() === $this) {
                $listnote->setSession(null);
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
            $gestionmatire->setSession($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getSession() === $this) {
                $gestionmatire->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Semestre>
     */
    public function getSemestres(): Collection
    {
        return $this->semestres;
    }

    public function addSemestre(Semestre $semestre): self
    {
        if (!$this->semestres->contains($semestre)) {
            $this->semestres[] = $semestre;
            $semestre->setSession($this);
        }

        return $this;
    }

    public function removeSemestre(Semestre $semestre): self
    {
        if ($this->semestres->removeElement($semestre)) {
            // set the owning side to null (unless already changed)
            if ($semestre->getSession() === $this) {
                $semestre->setSession(null);
            }
        }

        return $this;
    }
}
