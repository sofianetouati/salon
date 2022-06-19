<?php

namespace App\Entity;

use DateTimeInterface;
use App\Entity\Coiffeur;
use App\Entity\RestReason;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RestRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RestRepository::class)
 */
class Rest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull(message="Vous devez entrer une date de début de congé")
     */
    private $startAt;

    /**
    * @ORM\Column(type="date")
    * @Assert\NotNull(message="Vous devez entrer une date de retour de congé.")     
    */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity=Coiffeur::class, inversedBy="Rests")
     * @Assert\NotBlank(message="Vous devez choisir un coiffeur")
     */
    private $coiffeur;

    /**
     * @ORM\ManyToOne(targetEntity=RestReason::class, inversedBy="rest")
     * @Assert\NotBlank(message="Vous devez choisir une raison d'absence")
     */
    private $restReason;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCoiffeur(): ?Coiffeur
    {
        return $this->coiffeur;
    }

    public function setCoiffeur(?Coiffeur $coiffeur): self
    {
        $this->coiffeur = $coiffeur;

        return $this;
    }

    public function getRestReason(): ?RestReason
    {
        return $this->restReason;
    }

    public function setRestReason(?RestReason $restReason): self
    {
        $this->restReason = $restReason;

        return $this;
    }
}
