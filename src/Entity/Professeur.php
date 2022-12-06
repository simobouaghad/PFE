<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $sexe;

    #[ORM\Column(type: 'string', length: 255)]
    private $CIN;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'professeurs')]
    private $centre;

    #[ORM\Column(type: 'string', length: 255)]
    private $salary;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Calendaretude::class)]
    private $calendaretudes;

    #[ORM\OneToMany(mappedBy: 'prof', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $planning;

    public function __construct()
    {
        $this->calendaretudes = new ArrayCollection();
        $this->gestionmatires = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCIN(): ?string
    {
        return $this->CIN;
    }

    public function setCIN(string $CIN): self
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

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
            $calendaretude->setProfesseur($this);
        }

        return $this;
    }

    public function removeCalendaretude(Calendaretude $calendaretude): self
    {
        if ($this->calendaretudes->removeElement($calendaretude)) {
            // set the owning side to null (unless already changed)
            if ($calendaretude->getProfesseur() === $this) {
                $calendaretude->setProfesseur(null);
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
            $gestionmatire->setProf($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getProf() === $this) {
                $gestionmatire->setProf(null);
            }
        }

        return $this;
    }

    public function getPlanning(): ?string
    {
        return $this->planning;
    }

    public function setPlanning(?string $planning): self
    {
        $this->planning = $planning;

        return $this;
    }
}
