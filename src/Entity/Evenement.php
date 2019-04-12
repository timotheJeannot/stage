<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotNull(message="Veuillez renseigner un nom pour l'événement")
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
	 * @Assert\NotNull(message="Veuillez renseigner une descpription pour l'événement")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\Url(message="veuillez indiquer une url valide")
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="evenements")
     */
    private $estDans;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\IntervalleTemps", inversedBy="evenements")
     */
    private $periode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="evenement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organisateur", inversedBy="Evenement")
     */
    private $organisateurs;

    /**
     * @ORM\Column(type="datetime")
     */
    private $PublishedAt;

    public function __construct()
    {
        $this->estDans = new ArrayCollection();
        $this->periode = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Collection|Article[]
     */
    public function getEstDans(): Collection
    {
        return $this->estDans;
    }

    public function addEstDan(Article $estDan): self
    {
        if (!$this->estDans->contains($estDan)) {
            $this->estDans[] = $estDan;
        }

        return $this;
    }

    public function removeEstDan(Article $estDan): self
    {
        if ($this->estDans->contains($estDan)) {
            $this->estDans->removeElement($estDan);
        }

        return $this;
    }

    /**
     * @return Collection|IntervalleTemps[]
     */
    public function getPeriode(): Collection
    {
        return $this->periode;
    }

    public function addPeriode(IntervalleTemps $periode): self
    {
        if (!$this->periode->contains($periode)) {
            $this->periode[] = $periode;
        }

        return $this;
    }

    public function removePeriode(IntervalleTemps $periode): self
    {
        if ($this->periode->contains($periode)) {
            $this->periode->removeElement($periode);
        }

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

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
            //$organisateur->addEvenement($this);
        }

        return $this;
    }

    public function removeOrganisateur(Organisateur $organisateur): self
    {
        if ($this->organisateurs->contains($organisateur)) {
            $this->organisateurs->removeElement($organisateur);
            //$organisateur->removeEvenement($this);
        }

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->PublishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $PublishedAt): self
    {
        $this->PublishedAt = $PublishedAt;

        return $this;
    }
}
