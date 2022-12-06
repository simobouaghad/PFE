<?php

namespace App\Entity;

use App\Repository\GestionmatireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionmatireRepository::class)]
class Gestionmatire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'gestionmatires')]
    private $category;

    #[ORM\ManyToOne(targetEntity: SousCategory::class, inversedBy: 'gestionmatires')]
    private $souscategory;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'gestionmatires')]
    private $groupe;

    #[ORM\ManyToOne(targetEntity: Matire::class, inversedBy: 'gestionmatires')]
    private $matire;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'gestionmatires')]
    private $prof;

    #[ORM\ManyToOne(targetEntity: Session::class, inversedBy: 'gestionmatires')]
    private $session;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'gestionmatires')]
    private $centre;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSouscategory(): ?SousCategory
    {
        return $this->souscategory;
    }

    public function setSouscategory(?SousCategory $souscategory): self
    {
        $this->souscategory = $souscategory;

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

    public function getProf(): ?Professeur
    {
        return $this->prof;
    }

    public function setProf(?Professeur $prof): self
    {
        $this->prof = $prof;

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

    public function getCentre(): ?Centre
    {
        return $this->centre;
    }

    public function setCentre(?Centre $centre): self
    {
        $this->centre = $centre;

        return $this;
    }
}
