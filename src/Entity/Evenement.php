<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ListeContact", mappedBy="evenement")
     */
    private $listesContact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="evenements")
     */
    private $utilisateur;

    public function __construct()
    {
        $this->estDans = new ArrayCollection();
        $this->periode = new ArrayCollection();
        $this->organisateurs = new ArrayCollection();
        $this->listesContact = new ArrayCollection();
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
            $estDan->addEvenement($this);
        }

        return $this;
    }

    public function removeEstDan(Article $estDan): self
    {
        if ($this->estDans->contains($estDan)) {
            $this->estDans->removeElement($estDan);
            $estDan->removeEvenement($this);
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

    /* le code listeContact généré par la cli est en bas*/

    /**
	* @Assert\Callback
    */
    
	public function validate(ExecutionContextInterface $context, $payload)
                        	{
                        		
                                // on va vérifier que les intervalles de temps n'ont pas de temps en commun
                        
                                for($i =0 ; $i< count($this->periode) ; $i++)
                                {
                        
                                    for($j=$i+1 ; $j<count($this->periode) ; $j++)
                                    {
                                        if($this->periode[$this->periode->getKeys()[$i]]->isInSameTime($this->periode[$this->periode->getKeys()[$j]]))
                                        {
                                            $context->buildViolation('Il y a deux intervalles de temps qui partagent un même créneau horaire dans l\' événement '.$this->nom)
                        					->atPath('periode')
                        					->addViolation();
                                        }
                                    }
                                    
                        
                                }
                        
                                // ici il va falloir vérifier que il n'y a pas plusieurs fois le 
                                //même organisateur et qu'il n'y a pas plusieurs fois le même contact
                                //au sein d'un même organisateur , par contre il peut y
                                // avoir plusieurs fois le même contact si il apparait chez des organisateurs
                                //différents
                        
                                for($i=0 ; $i <count($this->organisateurs) ; $i++)
                                {
                                    $orgaI = &$this->organisateurs[$this->organisateurs->getKeys()[$i]];
                                    for($j=$i+1 ; $j<count($this->organisateurs) ; $j++)
                                    {
                                        // on va supposer que deux organisateurs différents ne peuvent pas avoir le même nom
                                        if($orgaI->getNom() == $this->organisateurs[$this->organisateurs->getKeys()[$j]]->getNom())
                                        {
                                            
                                            $context->buildViolation('Il y a deux organisateurs qui portent le même nom dans l\'événément '.$this->nom)
                        					->atPath('organisateurs')
                        					->addViolation();
                                            
                                        }
                                    }
                                    
                        
                                    for($j=0 ; $j<count($orgaI->getContacts()) ; $j++)
                                    {
                                        $orgaI->getContacts()[$orgaI->getContacts()->getKeys()[$j]]->setTelephone(str_replace(" ","",$orgaI->getContacts()[$orgaI->getContacts()->getKeys()[$j]]->getTelephone()))  ;
                                        for($k=$j+1 ; $k<count($orgaI->getContacts()) ; $k++)
                                        {
                                            
                                            //$orgaI->getContacts()[$orgaI->getContacts()->getKeys()[$k]]->setTelephone( str_replace(" ","",$orgaI->getContacts()[$orgaI->getContacts()->getKeys()[$k]]->getTelephone())) ;
                                            // l'égalité portent sur tous les attributs , mais il faudrait peut être pas prendre en compte le téléphone
                                            if($orgaI->getContacts()[$orgaI->getContacts()->getKeys()[$j]] == $orgaI->getContacts()[$orgaI->getContacts()->getKeys()[$k]])
                                            {
                                                $context->buildViolation('Il y a deux contacts identiques dans l\'événément '.$this->nom." dans l'organisateur ".$orgaI->getNom())
                        					    ->atPath('organisateurs')
                        					    ->addViolation();
                                            }
                                        }
                                    }
                                }
                                
                            }

    /**
     * @return Collection|ListeContact[]
     */
    public function getListesContact(): Collection
    {
        return $this->listesContact;
    }

    public function addListesContact(ListeContact $listesContact): self
    {
        if (!$this->listesContact->contains($listesContact)) {
            $this->listesContact[] = $listesContact;
            $listesContact->setEvenement($this);
        }

        return $this;
    }

    public function removeListesContact(ListeContact $listesContact): self
    {
        if ($this->listesContact->contains($listesContact)) {
            $this->listesContact->removeElement($listesContact);
            // set the owning side to null (unless already changed)
            if ($listesContact->getEvenement() === $this) {
                $listesContact->setEvenement(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    // cette fonction renvoie le DateTime de départ de l'événement
    public function getBeginAt()
    {
        //$start = new DateTime();
        if(count($this->getPeriode()) >0)
        {
            $start = $this->getPeriode()[$this->getPeriode()->getKeys()[0]]->getDebut();

            foreach($this->getPeriode() as $key)
            {
                if($start->getTimeStamp() > $key->getDebut()->getTimeStamp())
                {
                    $start = $key->getDebut();
                }                
            }
            return $start;
        }
        // je ne sais pas quoi renvoyer si l'événement n'a pas de date
        // cette fonction est à pour le calendrier , qui est fait grâce au bundle
        // https://github.com/tattali/CalendarBundle/blob/HEAD/src/Resources/doc/doctrine-crud.md#full-listener
        return new DateTime();
    }

    // cette fonction renvoie le DateTime de fin de l'événement
    public function getEndAt()
    {
        //$start = new DateTime();
        if(count($this->getPeriode()) >0)
        {
            $start = $this->getPeriode()[$this->getPeriode()->getKeys()[0]]->getFin();
            foreach($this->getPeriode() as $key)
            {
                if($start->getTimeStamp() < $key->getFin()->getTimeStamp())
                {
                    $start = $key->getFin();
                }                
            }
            return $start;
        }
        // je ne sais pas quoi renvoyer si l'événement n'a pas de date
        // cette fonction est à pour le calendrier , qui est fait grâce au bundle
        // https://github.com/tattali/CalendarBundle/blob/HEAD/src/Resources/doc/doctrine-crud.md#full-listener
        return new DateTime();
    }
    
    
}
