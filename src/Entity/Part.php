<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartRepository")
 */
class Part
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Veuillez renseigner le contenu de la question")
     */
    private $question;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reponse; // la réponse peut être null ne pas mettre d'assert sur ce champ

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Satisfaction", inversedBy="parts")
     */
    private $satisfaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getSatisfaction(): ?Satisfaction
    {
        return $this->satisfaction;
    }

    public function setSatisfaction(?Satisfaction $satisfaction): self
    {
        $this->satisfaction = $satisfaction;

        return $this;
    }
}
