<?php

namespace App\Entity;

use App\Repository\SousCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousCategoryRepository::class)]
class SousCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'sousCategories')]
    private $category;

    #[ORM\OneToMany(mappedBy: 'souscategory', targetEntity: Groupe::class)]
    private $groupes;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'sousCategories')]
    private $centre;

    #[ORM\OneToMany(mappedBy: 'sousCategory', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'sousCategory', targetEntity: Matire::class)]
    private $matires;

    #[ORM\OneToMany(mappedBy: 'souscategory', targetEntity: Payement::class)]
    private $payements;

    #[ORM\OneToMany(mappedBy: 'souscategory', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\OneToMany(mappedBy: 'sousCategory', targetEntity: Lessons::class)]
    private $lessons;

    #[ORM\OneToMany(mappedBy: 'souscategory', targetEntity: Planning::class)]
    private $plannings;

    #[ORM\OneToMany(mappedBy: 'sousCategory', targetEntity: Exams::class)]
    private $exams;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->matires = new ArrayCollection();
        $this->payements = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function __toString() {
        return $this->name;
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
            $groupe->setSouscategory($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getSouscategory() === $this) {
                $groupe->setSouscategory(null);
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
            $etudiant->setSousCategory($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getSousCategory() === $this) {
                $etudiant->setSousCategory(null);
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
            $matire->setSousCategory($this);
        }

        return $this;
    }

    public function removeMatire(Matire $matire): self
    {
        if ($this->matires->removeElement($matire)) {
            // set the owning side to null (unless already changed)
            if ($matire->getSousCategory() === $this) {
                $matire->setSousCategory(null);
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
            $payement->setSouscategory($this);
        }

        return $this;
    }

    public function removePayement(Payement $payement): self
    {
        if ($this->payements->removeElement($payement)) {
            // set the owning side to null (unless already changed)
            if ($payement->getSouscategory() === $this) {
                $payement->setSouscategory(null);
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
            $gestionmatire->setSouscategory($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getSouscategory() === $this) {
                $gestionmatire->setSouscategory(null);
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
            $lesson->setSousCategory($this);
        }

        return $this;
    }

    public function removeLesson(Lessons $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getSousCategory() === $this) {
                $lesson->setSousCategory(null);
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
            $planning->setSouscategory($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getSouscategory() === $this) {
                $planning->setSouscategory(null);
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
            $exam->setSousCategory($this);
        }

        return $this;
    }

    public function removeExam(Exams $exam): self
    {
        if ($this->exams->removeElement($exam)) {
            // set the owning side to null (unless already changed)
            if ($exam->getSousCategory() === $this) {
                $exam->setSousCategory(null);
            }
        }

        return $this;
    }
}
