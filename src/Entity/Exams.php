<?php

namespace App\Entity;

use App\Repository\ExamsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamsRepository::class)]
class Exams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'exams')]
    private $category;

    #[ORM\ManyToOne(targetEntity: SousCategory::class, inversedBy: 'exams')]
    private $sousCategory;

    #[ORM\Column(type: 'string', length: 255)]
    private $examplan;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'exams')]
    private $centre;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

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

    public function getSousCategory(): ?SousCategory
    {
        return $this->sousCategory;
    }

    public function setSousCategory(?SousCategory $sousCategory): self
    {
        $this->sousCategory = $sousCategory;

        return $this;
    }

    public function getExamplan(): ?string
    {
        return $this->examplan;
    }

    public function setExamplan(string $examplan): self
    {
        $this->examplan = $examplan;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
