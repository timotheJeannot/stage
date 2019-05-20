<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IntervalleTempsRepository")
 */
class IntervalleTemps
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
	 * @Assert\DateTime
	 * @Assert\GreaterThan("today" , message="La date de début doit être supérieur à la date du jour")
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime")
	 * @Assert\DateTime
     */
    private $fin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evenement", mappedBy="periode")
     */
    private $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->debut = new \DateTime();
        $this->fin = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

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
            $evenement->addPeriode($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            $evenement->removePeriode($this);
        }

        return $this;
    }

	/* fin du code généré par la CLI */

	/* la fonction ci dessous va vérifier si la date de début est inclus dans $i ou si le debut de $i est inclus dans $this */
	public function IsInSameTime(IntervalleTemps $i)
	{
		

		/* je ne pense pas que getTimestamp soit couteux , mais si c'est le  cas n'hésitez pas à stocker au préalable dans des variables*/
		if($this->debut->getTimestamp() >= $i->getDebut()->getTimestamp() && $this->debut->getTimestamp() < $i->getFin()->getTimestamp())
		{
			return true;
		}
		else 
		{
			if($i->getDebut()->getTimestamp() >= $this->debut->getTimestamp() && $i->getDebut()->getTimestamp() < $this->fin->getTimestamp())
			{
				return true;
			}
			return false;
		}


		return false ;
		
		
	}
	
	/**
	* @Assert\Callback
	*/
	public function validate(ExecutionContextInterface $context, $payload)
	{
		
		if($this->debut->getTimestamp() > $this->fin->getTimestamp())
		{
			$context->buildViolation('La date de début doit être inférieur à la date de fin')
					->atPath('fin')
					->addViolation();
		}
	}
	/* @Assert\GreaterThan(propertyPath="debut") permet de faire le boulot de la fonction */ 
	



}
