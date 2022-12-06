<?php

namespace App\Entity;

use App\Repository\MatireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatireRepository::class)]
class Matire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'matires')]
    private $centre;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'matires')]
    private $category;

    #[ORM\ManyToOne(targetEntity: SousCategory::class, inversedBy: 'matires')]
    private $sousCategory;

    #[ORM\OneToMany(mappedBy: 'matire', targetEntity: Calendaretude::class)]
    private $calendaretudes;

    #[ORM\Column(type: 'integer')]
    private $coefficient;

    #[ORM\OneToMany(mappedBy: 'matire', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\OneToMany(mappedBy: 'matire', targetEntity: Listnote::class)]
    private $listnotes;

    #[ORM\OneToMany(mappedBy: 'matire', targetEntity: Lessons::class)]
    private $lessons;

    public function __construct()
    {
        $this->calendaretudes = new ArrayCollection();
        $this->gestionmatires = new ArrayCollection();
        $this->listnotes = new ArrayCollection();
        $this->lessons = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getSousCategory(): ?SousCategory
    {
        return $this->sousCategory;
    }

    public function setSousCategory(?SousCategory $sousCategory): self
    {
        $this->sousCategory = $sousCategory;

        return $this;
    }

    public function __toString() {
        return $this->name;
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
            $calendaretude->setMatire($this);
        }

        return $this;
    }

    public function removeCalendaretude(Calendaretude $calendaretude): self
    {
        if ($this->calendaretudes->removeElement($calendaretude)) {
            // set the owning side to null (unless already changed)
            if ($calendaretude->getMatire() === $this) {
                $calendaretude->setMatire(null);
            }
        }

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    public function setCoefficient(int $coefficient): self
    {
        $this->coefficient = $coefficient;

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
            $gestionmatire->setMatire($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getMatire() === $this) {
                $gestionmatire->setMatire(null);
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
            $listnote->setMatire($this);
        }

        return $this;
    }

    public function removeListnote(Listnote $listnote): self
    {
        if ($this->listnotes->removeElement($listnote)) {
            // set the owning side to null (unless already changed)
            if ($listnote->getMatire() === $this) {
                $listnote->setMatire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lessons>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lessons $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setMatire($this);
        }

        return $this;
    }

    public function removeLesson(Lessons $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getMatire() === $this) {
                $lesson->setMatire(null);
            }
        }

        return $this;
    }
}
