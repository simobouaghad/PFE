<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 1500)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: SousCategory::class)]
    private $sousCategories;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'categories')]
    private $centre;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Groupe::class)]
    private $groupes;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Matire::class)]
    private $matires;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Lessons::class)]
    private $lessons;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Planning::class)]
    private $plannings;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Exams::class)]
    private $exams;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->matires = new ArrayCollection();
        $this->gestionmatires = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->exams = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection<int, SousCategory>
     */
    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategory(SousCategory $sousCategory): self
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories[] = $sousCategory;
            $sousCategory->setCategory($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategory $sousCategory): self
    {
        if ($this->sousCategories->removeElement($sousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCategory() === $this) {
                $sousCategory->setCategory(null);
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

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setCategory($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getCategory() === $this) {
                $groupe->setCategory(null);
            }
        }

        return $this;
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
            $etudiant->setCategory($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getCategory() === $this) {
                $etudiant->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matire>
     */
    public function getMatires(): Collection
    {
        return $this->matires;
    }

    public function addMatire(Matire $matire): self
    {
        if (!$this->matires->contains($matire)) {
            $this->matires[] = $matire;
            $matire->setCategory($this);
        }

        return $this;
    }

    public function removeMatire(Matire $matire): self
    {
        if ($this->matires->removeElement($matire)) {
            // set the owning side to null (unless already changed)
            if ($matire->getCategory() === $this) {
                $matire->setCategory(null);
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
            $gestionmatire->setCategory($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getCategory() === $this) {
                $gestionmatire->setCategory(null);
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
            $lesson->setCategory($this);
        }

        return $this;
    }

    public function removeLesson(Lessons $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getCategory() === $this) {
                $lesson->setCategory(null);
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
            $planning->setCategory($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getCategory() === $this) {
                $planning->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exams>
     */
    public function getExams(): Collection
    {
        return $this->exams;
    }

    public function addExam(Exams $exam): self
    {
        if (!$this->exams->contains($exam)) {
            $this->exams[] = $exam;
            $exam->setCategory($this);
        }

        return $this;
    }

    public function removeExam(Exams $exam): self
    {
        if ($this->exams->removeElement($exam)) {
            // set the owning side to null (unless already changed)
            if ($exam->getCategory() === $this) {
                $exam->setCategory(null);
            }
        }

        return $this;
    }
}
