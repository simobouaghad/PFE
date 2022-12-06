<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'plannings')]
    private $centre;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'plannings')]
    private $category;

    #[ORM\ManyToOne(targetEntity: SousCategory::class, inversedBy: 'plannings')]
    private $souscategory;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'plannings')]
    private $groupe;

    #[ORM\Column(type: 'string', length: 255)]
    private $planning;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlanning(): ?string
    {
        return $this->planning;
    }

    public function setPlanning(string $planning): self
    {
        $this->planning = $planning;

        return $this;
    }
}
