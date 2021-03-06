<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscritRepository")
 */
class Inscrit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez renseigner un nom ")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez renseigner un prenom ")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez renseigner un mail ")
     * @Assert\Email(message="veuillez indiquer un email valide")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez renseigner une catégorie ")
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evenement", mappedBy="inscrits")
     */
    private $evenements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Satisfaction", mappedBy="inscrit")
     */
    private $satisfactions;

    /**
     * @ORM\Column(type="integer")
     */
    private $randomNumber;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->satisfactions = new ArrayCollection();
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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->addInscrit($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            $evenement->removeInscrit($this);
        }

        return $this;
    }

    /**
     * @return Collection|Satisfaction[]
     */
    public function getSatisfactions(): Collection
    {
        return $this->satisfactions;
    }

    public function addSatisfaction(Satisfaction $satisfaction): self
    {
        if (!$this->satisfactions->contains($satisfaction)) {
            $this->satisfactions[] = $satisfaction;
            $satisfaction->setInscrit($this);
        }

        return $this;
    }

    public function removeSatisfaction(Satisfaction $satisfaction): self
    {
        if ($this->satisfactions->contains($satisfaction)) {
            $this->satisfactions->removeElement($satisfaction);
            // set the owning side to null (unless already changed)
            if ($satisfaction->getInscrit() === $this) {
                $satisfaction->setInscrit(null);
            }
        }

        return $this;
    }

    public function getRandomNumber(): ?int
    {
        return $this->randomNumber;
    }

    public function setRandomNumber(int $randomNumber): self
    {
        $this->randomNumber = $randomNumber;

        return $this;
    }
}
