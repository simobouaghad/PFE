<?php

namespace App\Entity;

use App\Repository\ListpaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListpaymentRepository::class)]
class Listpayment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $from_;

    #[ORM\Column(type: 'string', length: 255)]
    private $to_;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    private $cne;

    #[ORM\Column(type: 'string', length: 255)]
    private $methodepay;

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

    public function getFrom(): ?string
    {
        return $this->from_;
    }

    public function setFrom(string $from_): self
    {
        $this->from_ = $from_;

        return $this;
    }

    public function getTo(): ?string
    {
        return $this->to_;
    }

    public function setTo(string $to_): self
    {
        $this->to_ = $to_;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

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

    public function getMethodepay(): ?string
    {
        return $this->methodepay;
    }

    public function setMethodepay(string $methodepay): self
    {
        $this->methodepay = $methodepay;

        return $this;
    }
}
