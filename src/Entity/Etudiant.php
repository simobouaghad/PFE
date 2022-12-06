<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
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
    private $nompere;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenompere;

    #[ORM\Column(type: 'string', length: 255)]
    private $CNIpere;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\ManyToOne(targetEntity: Session::class, inversedBy: 'etudiants')]
    private $annee;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'etudiants')]
    private $groupe;

    #[ORM\ManyToOne(targetEntity: Centre::class, inversedBy: 'etudiants')]
    private $centre;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'etudiants')]
    private $category;

    #[ORM\ManyToOne(targetEntity: SousCategory::class, inversedBy: 'etudiants')]
    private $sousCategory;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'etudiants')]
    private $ville;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\ManyToOne(targetEntity: Methdepay::class, inversedBy: 'etudiants')]
    private $methdepay;

    #[ORM\Column(type: 'string', length: 255)]
    private $cne;

    #[ORM\ManyToOne(targetEntity: Payement::class, inversedBy: 'etudiants')]
    private $payement;

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

    public function getNompere(): ?string
    {
        return $this->nompere;
    }

    public function setNompere(string $nompere): self
    {
        $this->nompere = $nompere;

        return $this;
    }

    public function getPrenompere(): ?string
    {
        return $this->prenompere;
    }

    public function setPrenompere(string $prenompere): self
    {
        $this->prenompere = $prenompere;

        return $this;
    }

    public function getCNIpere(): ?string
    {
        return $this->CNIpere;
    }

    public function setCNIpere(string $CNIpere): self
    {
        $this->CNIpere = $CNIpere;

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

    public function getAnnee(): ?Session
    {
        return $this->annee;
    }

    public function setAnnee(?Session $annee): self
    {
        $this->annee = $annee;

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

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

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

    public function getMethdepay(): ?Methdepay
    {
        return $this->methdepay;
    }

    public function setMethdepay(?Methdepay $methdepay): self
    {
        $this->methdepay = $methdepay;

        return $this;
    }

    public function getCne(): ?string
    {
        return $this->cne;
    }

    public function setCne(string $cne): self
    {
        $this->cne = $cne;

        return $this;
    }

    public function getPayement(): ?Payement
    {
        return $this->payement;
    }

    public function setPayement(?Payement $payement): self
    {
        $this->payement = $payement;

        return $this;
    }
}
