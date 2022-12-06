<?php

namespace App\Entity;

use App\Repository\CentreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CentreRepository::class)]
class Centre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $location;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'centres')]
    private $ville;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Directeur::class)]
    private $directeurs;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Category::class)]
    private $categories;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: SousCategory::class)]
    private $sousCategories;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Groupe::class)]
    private $groupes;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Sale::class)]
    private $sales;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Matire::class)]
    private $matires;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Professeur::class)]
    private $professeurs;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: User::class)]
    private $users;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Employeur::class)]
    private $employeurs;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Garde::class)]
    private $gardes;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Comptable::class)]
    private $comptables;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Payement::class)]
    private $payements;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Methdepay::class)]
    private $methdepays;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Gestionmatire::class)]
    private $gestionmatires;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Lessons::class)]
    private $lessons;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Planning::class)]
    private $plannings;

    #[ORM\OneToMany(mappedBy: 'centre', targetEntity: Exams::class)]
    private $exams;



    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->directeurs = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->sousCategories = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->sales = new ArrayCollection();
        $this->matires = new ArrayCollection();
        $this->professeurs = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->employeurs = new ArrayCollection();
        $this->gardes = new ArrayCollection();
        $this->comptables = new ArrayCollection();
        $this->payements = new ArrayCollection();
        $this->methdepays = new ArrayCollection();
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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
            $etudiant->setCentre($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getCentre() === $this) {
                $etudiant->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Directeur>
     */
    public function getDirecteurs(): Collection
    {
        return $this->directeurs;
    }

    public function addDirecteur(Directeur $directeur): self
    {
        if (!$this->directeurs->contains($directeur)) {
            $this->directeurs[] = $directeur;
            $directeur->setCentre($this);
        }

        return $this;
    }

    public function removeDirecteur(Directeur $directeur): self
    {
        if ($this->directeurs->removeElement($directeur)) {
            // set the owning side to null (unless already changed)
            if ($directeur->getCentre() === $this) {
                $directeur->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCentre($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCentre() === $this) {
                $category->setCentre(null);
            }
        }

        return $this;
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
            $sousCategory->setCentre($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategory $sousCategory): self
    {
        if ($this->sousCategories->removeElement($sousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCentre() === $this) {
                $sousCategory->setCentre(null);
            }
        }

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
            $groupe->setCentre($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getCentre() === $this) {
                $groupe->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sale>
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sale $sale): self
    {
        if (!$this->sales->contains($sale)) {
            $this->sales[] = $sale;
            $sale->setCentre($this);
        }

        return $this;
    }

    public function removeSale(Sale $sale): self
    {
        if ($this->sales->removeElement($sale)) {
            // set the owning side to null (unless already changed)
            if ($sale->getCentre() === $this) {
                $sale->setCentre(null);
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
            $matire->setCentre($this);
        }

        return $this;
    }

    public function removeMatire(Matire $matire): self
    {
        if ($this->matires->removeElement($matire)) {
            // set the owning side to null (unless already changed)
            if ($matire->getCentre() === $this) {
                $matire->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs[] = $professeur;
            $professeur->setCentre($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->removeElement($professeur)) {
            // set the owning side to null (unless already changed)
            if ($professeur->getCentre() === $this) {
                $professeur->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCentre($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCentre() === $this) {
                $user->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Employeur>
     */
    public function getEmployeurs(): Collection
    {
        return $this->employeurs;
    }

    public function addEmployeur(Employeur $employeur): self
    {
        if (!$this->employeurs->contains($employeur)) {
            $this->employeurs[] = $employeur;
            $employeur->setCentre($this);
        }

        return $this;
    }

    public function removeEmployeur(Employeur $employeur): self
    {
        if ($this->employeurs->removeElement($employeur)) {
            // set the owning side to null (unless already changed)
            if ($employeur->getCentre() === $this) {
                $employeur->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Garde>
     */
    public function getGardes(): Collection
    {
        return $this->gardes;
    }

    public function addGarde(Garde $garde): self
    {
        if (!$this->gardes->contains($garde)) {
            $this->gardes[] = $garde;
            $garde->setCentre($this);
        }

        return $this;
    }

    public function removeGarde(Garde $garde): self
    {
        if ($this->gardes->removeElement($garde)) {
            // set the owning side to null (unless already changed)
            if ($garde->getCentre() === $this) {
                $garde->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comptable>
     */
    public function getComptables(): Collection
    {
        return $this->comptables;
    }

    public function addComptable(Comptable $comptable): self
    {
        if (!$this->comptables->contains($comptable)) {
            $this->comptables[] = $comptable;
            $comptable->setCentre($this);
        }

        return $this;
    }

    public function removeComptable(Comptable $comptable): self
    {
        if ($this->comptables->removeElement($comptable)) {
            // set the owning side to null (unless already changed)
            if ($comptable->getCentre() === $this) {
                $comptable->setCentre(null);
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
            $payement->setCentre($this);
        }

        return $this;
    }

    public function removePayement(Payement $payement): self
    {
        if ($this->payements->removeElement($payement)) {
            // set the owning side to null (unless already changed)
            if ($payement->getCentre() === $this) {
                $payement->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Methdepay>
     */
    public function getMethdepays(): Collection
    {
        return $this->methdepays;
    }

    public function addMethdepay(Methdepay $methdepay): self
    {
        if (!$this->methdepays->contains($methdepay)) {
            $this->methdepays[] = $methdepay;
            $methdepay->setCentre($this);
        }

        return $this;
    }

    public function removeMethdepay(Methdepay $methdepay): self
    {
        if ($this->methdepays->removeElement($methdepay)) {
            // set the owning side to null (unless already changed)
            if ($methdepay->getCentre() === $this) {
                $methdepay->setCentre(null);
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
            $gestionmatire->setCentre($this);
        }

        return $this;
    }

    public function removeGestionmatire(Gestionmatire $gestionmatire): self
    {
        if ($this->gestionmatires->removeElement($gestionmatire)) {
            // set the owning side to null (unless already changed)
            if ($gestionmatire->getCentre() === $this) {
                $gestionmatire->setCentre(null);
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
            $lesson->setCentre($this);
        }

        return $this;
    }

    public function removeLesson(Lessons $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getCentre() === $this) {
                $lesson->setCentre(null);
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
            $planning->setCentre($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getCentre() === $this) {
                $planning->setCentre(null);
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
            $exam->setCentre($this);
        }

        return $this;
    }

    public function removeExam(Exams $exam): self
    {
        if ($this->exams->removeElement($exam)) {
            // set the owning side to null (unless already changed)
            if ($exam->getCentre() === $this) {
                $exam->setCentre(null);
            }
        }

        return $this;
    }

    

    
}
