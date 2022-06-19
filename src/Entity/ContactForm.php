<?php

namespace App\Entity;

use App\Repository\ContactFormRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactFormRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ContactForm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre nom")
     * @Assert\Length(min=3, minMessage="Votre nom doit contenir au moins 3 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner votre adresse email")
     * @Assert\Email(message="Cette adresse n'est pas valide")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez taper un message")
     * @Assert\Length(min=10,max=255, minMessage="Votre message doit contenir au moins 20 caractères")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendAt;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\IsTrue(message="Vous devez accepter les conditions pour envoyer un message")
     */
    private $isGrpd;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (empty($this->sendAt)) {
            $this->sendAt = new DateTime();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function getIsGrpd(): ?bool
    {
        return $this->isGrpd;
    }

    public function setIsGrpd(bool $isGrpd): self
    {
        $this->isGrpd = $isGrpd;

        return $this;
    }
}
