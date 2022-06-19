<?php

namespace App\Entity;

use DateTime;
use App\Entity\User;
use App\Entity\Salon;
use App\Entity\Product;
use App\Entity\Coiffeur;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraints as Assert;


const STATUS_WAITING = 'success';  
const STATUS_FINISHED = 'warning';  
const STATUS_CANCELED = 'danger';  
/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Vous devez choisir un créneau pour valider votre rendez-vous")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Salon::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $Salon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookerFullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bookerEmail;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $bookerPhone;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productName;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $color = '#5CB40B';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = STATUS_WAITING;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCancel = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $cancelledAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productDetail;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $productDuration;

    /**
     * @ORM\ManyToOne(targetEntity=Coiffeur::class, inversedBy="bookings")
     * @Assert\NotBlank(message="Vous devez d'abord choisir le coiffeur pour voir ses disponibilités")
     */
    private $coiffeur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPhoneBooking = false;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $cancellerRoles = [];



    public function isBookable(){

        // 1) Il faut connaitre les dates qui sont impossibles pour le salon
        $notAvailableSlots  = $this->coiffeur->getNotAvailableSlots();
        
        // 2) Il faut comparer les dates choisis avec les dates impossibles
        $bookingSlots       = $this->getSlots();

        $formatSlot = function($slot){
            return $slot->format('Y-m-d H:i');
        };

        // Tableau qui contient des chaines de caractere de mes creneaux
        $slots             = array_map($formatSlot, $bookingSlots);

        $notAvailable      = array_map($formatSlot,$notAvailableSlots);

        foreach ($slots as $slot ) {
            if(array_search($slot, $notAvailable) !== false) return false;
        }

        return true;
    }
    /**
     * Permet de récupérer les créneaux qui correspondent à ma réservation
     * 
     * @return array Un tableau d'objet DateTime représentant les créneaux de la réservation
     */
    public function getSlots(){
        $resultat = range(
            $this->getBeginAt()->getTimestamp(),
            $this->getEndAt()->getTimestamp(),
            60 - 1
        );

        $slots = array_map(function($slotTimestamp){
                return new \DateTime(date('Y-m-d H:i', $slotTimestamp));
            },
            $resultat
        );
        return $slots;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

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

    public function getBookerFullname(): ?string
    {
        return $this->bookerFullname;
    }

    public function setBookerFullname(string $bookerFullname): self
    {
        $this->bookerFullname = $bookerFullname;

        return $this;
    }

    public function getBookerEmail(): ?string
    {
        return $this->bookerEmail;
    }

    public function setBookerEmail(string $bookerEmail): self
    {
        $this->bookerEmail = $bookerEmail;

        return $this;
    }

    public function getBookerPhone(): ?string
    {
        return $this->bookerPhone;
    }

    public function setBookerPhone(string $bookerPhone): self
    {
        $this->bookerPhone = $bookerPhone;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {

        $this->productName = $productName;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

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

    public function getIsCancel(): ?bool
    {
        return $this->isCancel;
    }

    public function setIsCancel(bool $isCancel): self
    {
        $this->isCancel = $isCancel;
        
        if($this->isCancel === TRUE){
            $this->status === STATUS_CANCELED;
        }

        return $this;
    }

    public function getCancelledAt(): ?\DateTimeInterface
    {
        return $this->cancelledAt;
    }

    public function setCancelledAt(?\DateTimeInterface $cancelledAt): self
    {
        $this->cancelledAt = $cancelledAt;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductDetail(): ?string
    {
        return $this->productDetail;
    }

    public function setProductDetail(string $productDetail): self
    {
        
        $this->productDetail = $productDetail;

        return $this;
    }

    public function getProductDuration(): ?\DateInterval
    {
        return $this->productDuration;
    }

    public function setProductDuration(\DateInterval $productDuration): self
    {
        $this->productDuration = $productDuration;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsPhoneBooking(): ?bool
    {
        return $this->isPhoneBooking;
    }

    public function setIsPhoneBooking(bool $isPhoneBooking): self
    {
        $this->isPhoneBooking = $isPhoneBooking;

        return $this;
    }

    public function getCancellerRoles(): ?array
    {
        return $this->cancellerRoles;
    }

    public function setCancellerRoles(?array $cancellerRoles): self
    {
        $this->cancellerRoles = $cancellerRoles;

        return $this;
    }

    
}
