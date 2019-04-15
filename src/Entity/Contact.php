<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotNull(message="Veuillez renseigner un nom pour le contact")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotNull(message="Veuillez renseigner un prenom pour le contact")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\Email(message="veuillez indiquer un email valide")
	 * @Assert\NotNull(message="Veuillez renseigner un mail pour le contact")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\Regex(pattern ="/0\s*([0-9]\s*){9}/",message = "Le numéro de téléphone n'est pas valide")
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organisateur", mappedBy="contacts")
     */
    private $organisateurs;

    public function __construct()
    {
        $this->organisateurs = new ArrayCollection();
    }

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Organisateur[]
     */
    public function getOrganisateurs(): Collection
    {
        return $this->organisateurs;
    }

    public function addOrganisateur(Organisateur $organisateur): self
    {
        if (!$this->organisateurs->contains($organisateur)) {
            $this->organisateurs[] = $organisateur;
            $organisateur->addContact($this);
        }

        return $this;
    }

    public function removeOrganisateur(Organisateur $organisateur): self
    {
        if ($this->organisateurs->contains($organisateur)) {
            $this->organisateurs->removeElement($organisateur);
            $organisateur->removeContact($this);
        }

        return $this;
    }
}
