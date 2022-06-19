<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SalonRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SalonRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Salon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez entrer un nom pour votre salon.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer l'adresse de votre salon.")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le numéro de téléphone doit être au format 0606060606.")
     */
    private $phone;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="Salon")
     * 
     */
    private $bookings;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="salons")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $manager;

    /**
     * @ORM\OneToMany(targetEntity=Coiffeur::class, mappedBy="Salon")
     */
    private $coiffeurs;

    /**
     * @ORM\Column(type="time")
     */
    private $openAt;

    /**
     * @ORM\Column(type="time")
     */
    private $closeAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBookingOnline = false;

    

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->coiffeurs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new DateTime();
        }
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setSalon($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSalon() === $this) {
                $booking->setSalon(null);
            }
        }

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection|Coiffeur[]
     */
    public function getCoiffeurs(): Collection
    {
        return $this->coiffeurs;
    }

    public function addCoiffeur(Coiffeur $coiffeur): self
    {
        if (!$this->coiffeurs->contains($coiffeur)) {
            $this->coiffeurs[] = $coiffeur;
            $coiffeur->setSalon($this);
        }

        return $this;
    }

    public function removeCoiffeur(Coiffeur $coiffeur): self
    {
        if ($this->coiffeurs->removeElement($coiffeur)) {
            // set the owning side to null (unless already changed)
            if ($coiffeur->getSalon() === $this) {
                $coiffeur->setSalon(null);
            }
        }

        return $this;
    }

    public function getOpenAt(): ?\DateTimeInterface
    {
        return $this->openAt;
    }

    public function setOpenAt(\DateTimeInterface $openAt): self
    {
        $this->openAt = $openAt;

        return $this;
    }

    public function getCloseAt(): ?\DateTimeInterface
    {
        return $this->closeAt;
    }

    public function setCloseAt(\DateTimeInterface $closeAt): self
    {
        $this->closeAt = $closeAt;

        return $this;
    }

    public function getIsBookingOnline(): ?bool
    {
        return $this->isBookingOnline;
    }

    public function setIsBookingOnline(bool $isBookingOnline): self
    {
        $this->isBookingOnline = $isBookingOnline;

        return $this;
    }

    
}
