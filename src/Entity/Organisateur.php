<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganisateurRepository")
 */
class Organisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotNull(message="Veuillez renseigner un nom pour l'organisateur")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\Url(message="veuillez indiquer une url valide")
     */
    private $siteWeb;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\Email(message="veuillez indiquer un email valide")
	 * @Assert\NotNull(message="Veuillez renseigner un mail pour l'organisateur")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\Url(message="veuillez indiquer une url valide")
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evenement", mappedBy="organisateurs")
     */
    private $Evenement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contact", mappedBy="organisateurs")
     */
    private $contacts;

    public function __construct()
    {
        $this->Evenement = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenement(): Collection
    {
        return $this->Evenement;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->Evenement->contains($evenement)) {
            $this->Evenement[] = $evenement;
            $evenement->addOrganisateur($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->Evenement->contains($evenement)) {
            $this->Evenement->removeElement($evenement);
            $evenement->removeOrganisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->addOrganisateur($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            $contact->removeOrganisateur($this);
        }

        return $this;
    }
}
