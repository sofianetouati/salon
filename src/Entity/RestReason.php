<?php

namespace App\Entity;

use App\Repository\RestReasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestReasonRepository::class)
 */
class RestReason
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Rest::class, mappedBy="restReason")
     */
    private $rest;

    public function __construct()
    {
        $this->rest = new ArrayCollection();
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

    /**
     * @return Collection|Rest[]
     */
    public function getRest(): Collection
    {
        return $this->rest;
    }

    public function addRest(Rest $rest): self
    {
        if (!$this->rest->contains($rest)) {
            $this->rest[] = $rest;
            $rest->setRestReason($this);
        }

        return $this;
    }

    public function removeRest(Rest $rest): self
    {
        if ($this->rest->removeElement($rest)) {
            // set the owning side to null (unless already changed)
            if ($rest->getRestReason() === $this) {
                $rest->setRestReason(null);
            }
        }

        return $this;
    }
}
