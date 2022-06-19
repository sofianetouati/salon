<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use App\Repository\CoiffeurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CoiffeurRepository::class)
 */
class Coiffeur
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrez le prénom du coiffeur.")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrez le nom du coiffeur.")
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Salon::class, inversedBy="coiffeurs")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\NotBlank(message="Vous devez associer un salon à ce coiffeur.")
     */
    private $Salon;

    /**
     * @ORM\Column(type="boolean")
     */
    private $islinked;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="coiffeur")
     */
    private $bookings;

    /**
     * @ORM\Column(type="time")
     */
    private $jobStartAt;

    /**
     * @ORM\Column(type="time")
     */
    private $jobEndAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color = '#5CB40B';

    /**
     * @ORM\OneToMany(targetEntity=Rest::class, mappedBy="coiffeur")
     */
    private $Rests;

    
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->Rests = new ArrayCollection();        
    }

    
    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    }


    /**
     * Permet d'obtenir un tableau des heures qui sont disponibles pour le jour choisi
     *
     * @return array Un Tableau d'objet DateTime représentant les heures disponibles pour le jour choisi
     */
    public function getAvailableSlots(\DateTime $day){

        $now = new DateTime();
        $nowTimestamp = $now->getTimestamp();
        
        // Calculer les horaires du coiffeur du jour de la prise de rendez-vous
        $start = new DateTime(date($day->format('Y-m-d').' '.$this->jobStartAt->format('H:i')));
        $startJobTimestamp = $start->getTimestamp();

        $stop = new DateTime(date($day->format('Y-m-d').' '.$this->jobEndAt->format('H:i')));
        $stop->modify('- 30 minute');
        $stopJobTimestamp = $stop->getTimestamp();
        

        //Calculer une journée de travail en timestamp

            $resultats = range(
                $startJobTimestamp,
                $stopJobTimestamp,
                60 * 30
            );

        // Convertir une journée de travail du coiffeur, de timestamp au format date().
        $horaires = [];
        $dates = [];
        $now = new DateTime('now');
        $nowTimestamp = $now->getTimestamp();
        foreach ($resultats as $resultat) {
            if($nowTimestamp < $resultat){

                $horaires[] = $resultat;
            }
            $dates[] = date('Y-m-d', $resultat);
        }

        
        // calculer tous les créneaux indisponibles pour le jour sélectionné
        $notAvailables = [];
        
        foreach($this->getNotAvailableSlots() as $indispo){
                
            $notAvailables[] = $indispo->getTimestamp();
        }
        $rests = [];
        foreach($this->getNotAvailableRestSlots() as $rest){
                
            $rests[] = $rest->getTimestamp();
        }

        $notAvailables = array_merge($notAvailables,$rests);
        // Extraire les créneaux disponible dans un tableau.
        $availableSlots = array_diff($horaires, $notAvailables);
        
        $availableSlots = array_map(function($slotTimestamp){
            return new \DateTime(date('Y-m-d H:i', $slotTimestamp));
        }, $availableSlots);

        return $availableSlots;

    }

    /**
     * Permet d'obtenir un tableau des congés sous forme de créneau
     *
     * @return array Un Tableau d'objet DateTime représentant les heures de congés
     */
    public function getNotAvailableRestSlots(){
        $notAvailableRestSlots = [];

        // Calculer les créneaux qui se trouvent entre l'heure d'arrivé et de départ
        foreach($this->Rests as $rest){

                $resultat = range(
                    $rest->getStartAt()->getTimestamp(),
                    $rest->getEndAt()->getTimestamp(),
                    60 - 1
                    
                );
            
            $slots = array_map(function($slotTimestamp){
                return new \DateTime(date('Y-m-d H:i', $slotTimestamp));
            }, $resultat);

            $notAvailableRestSlots = array_merge($notAvailableRestSlots, $slots);
        }
        
        return $notAvailableRestSlots;
    }
    
    /**
     * Permet d'obtenir un tableau des heures qui ne sont pas disponibles
     *
     * @return array Un Tableau d'objet DateTime représentant les heures déjà réservés
     */
    public function getNotAvailableSlots(){
        $notAvailableSlots = [];

        // Calculer les créneaux qui se trouvent entre l'heure d'arrivé et de départ
        foreach($this->bookings as $booking){

                $resultat = range(
                    $booking->getBeginAt()->getTimestamp(),
                    $booking->getEndAt()->getTimestamp(),
                    60 - 1
                    
                );
            
            $slots = array_map(function($slotTimestamp){
                return new \DateTime(date('Y-m-d H:i', $slotTimestamp));
            }, $resultat);

            $notAvailableSlots = array_merge($notAvailableSlots, $slots);
        }
        
        return $notAvailableSlots;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSalon(): ?Salon
    {
        return $this->Salon;
    }

    public function setSalon(?Salon $Salon): self
    {
        $this->Salon = $Salon;

        return $this;
    }

    public function getIslinked(): ?bool
    {
        return $this->islinked;
    }

    public function setIslinked(bool $islinked): self
    {
        $this->islinked = $islinked;

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
            $booking->setCoiffeur($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCoiffeur() === $this) {
                $booking->setCoiffeur(null);
            }
        }

        return $this;
    }

    public function getJobStartAt(): ?\DateTimeInterface
    {
        return $this->jobStartAt;
    }

    public function setJobStartAt(\DateTimeInterface $jobStartAt): self
    {
        $this->jobStartAt = $jobStartAt;

        return $this;
    }

    public function getJobEndAt(): ?\DateTimeInterface
    {
        return $this->jobEndAt;
    }

    public function setJobEndAt(\DateTimeInterface $jobEndAt): self
    {
        $this->jobEndAt = $jobEndAt;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Rest[]
     */
    public function getRests(): Collection
    {
        return $this->Rests;
    }

    public function addRest(Rest $rest): self
    {
        if (!$this->Rests->contains($rest)) {
            $this->Rests[] = $rest;
            $rest->setCoiffeur($this);
        }

        return $this;
    }

    public function removeRest(Rest $rest): self
    {
        if ($this->Rests->removeElement($rest)) {
            // set the owning side to null (unless already changed)
            if ($rest->getCoiffeur() === $this) {
                $rest->setCoiffeur(null);
            }
        }

        return $this;
    }

}
