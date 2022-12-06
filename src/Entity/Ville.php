<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $postale;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Centre::class)]
    private $centres;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Directeur::class)]
    private $directeurs;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Etudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Sale::class)]
    private $sales;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Employeur::class)]
    private $employeurs;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Garde::class)]
    private $gardes;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: User::class)]
    private $users;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Comptable::class)]
    private $comptables;

    public function __construct()
    {
        $this->centres = new ArrayCollection();
        $this->directeurs = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->sales = new ArrayCollection();
        $this->employeurs = new ArrayCollection();
        $this->gardes = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->comptables = new ArrayCollection();
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

    public function getPostale(): ?string
    {
        return $this->postale;
    }

    public function setPostale(string $postale): self
    {
        $this->postale = $postale;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection<int, Centre>
     */
    public function getCentres(): Collection
    {
        return $this->centres;
    }

    public function addCentre(Centre $centre): self
    {
        if (!$this->centres->contains($centre)) {
            $this->centres[] = $centre;
            $centre->setVille($this);
        }

        return $this;
    }

    public function removeCentre(Centre $centre): self
    {
        if ($this->centres->removeElement($centre)) {
            // set the owning side to null (unless already changed)
            if ($centre->getVille() === $this) {
                $centre->setVille(null);
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
            $directeur->setVille($this);
        }

        return $this;
    }

    public function removeDirecteur(Directeur $directeur): self
    {
        if ($this->directeurs->removeElement($directeur)) {
            // set the owning side to null (unless already changed)
            if ($directeur->getVille() === $this) {
                $directeur->setVille(null);
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
            $etudiant->setVille($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getVille() === $this) {
                $etudiant->setVille(null);
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
            $sale->setVille($this);
        }

        return $this;
    }

    public function removeSale(Sale $sale): self
    {
        if ($this->sales->removeElement($sale)) {
            // set the owning side to null (unless already changed)
            if ($sale->getVille() === $this) {
                $sale->setVille(null);
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
            $employeur->setVille($this);
        }

        return $this;
    }

    public function removeEmployeur(Employeur $employeur): self
    {
        if ($this->employeurs->removeElement($employeur)) {
            // set the owning side to null (unless already changed)
            if ($employeur->getVille() === $this) {
                $employeur->setVille(null);
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
            $garde->setVille($this);
        }

        return $this;
    }

    public function removeGarde(Garde $garde): self
    {
        if ($this->gardes->removeElement($garde)) {
            // set the owning side to null (unless already changed)
            if ($garde->getVille() === $this) {
                $garde->setVille(null);
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
            $user->setVille($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getVille() === $this) {
                $user->setVille(null);
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
            $comptable->setVille($this);
        }

        return $this;
    }

    public function removeComptable(Comptable $comptable): self
    {
        if ($this->comptables->removeElement($comptable)) {
            // set the owning side to null (unless already changed)
            if ($comptable->getVille() === $this) {
                $comptable->setVille(null);
            }
        }

        return $this;
    }
}
