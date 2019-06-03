<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccueilRepository")
 */
class Accueil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Partenaires", cascade={"persist", "remove"})
     */
    private $partenaires;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\InfoSite", cascade={"persist", "remove"})
     */
    private $infoSite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartenaires(): ?Partenaires
    {
        return $this->partenaires;
    }

    public function setPartenaires(?Partenaires $partenaires): self
    {
        $this->partenaires = $partenaires;

        return $this;
    }

    public function getInfoSite(): ?InfoSite
    {
        return $this->infoSite;
    }

    public function setInfoSite(?InfoSite $infoSite): self
    {
        $this->infoSite = $infoSite;

        return $this;
    }
}
