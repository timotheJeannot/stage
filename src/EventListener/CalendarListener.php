<?php
//https://packagist.org/packages/tattali/calendar-bundle

namespace App\EventListener;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;

class CalendarListener
{
    private $EvenementRepository;
    private $router;

    public function __construct(
        EvenementRepository $EvenementRepository,
        UrlGeneratorInterface $router
    ) {
        $this->EvenementRepository = $EvenementRepository;
        $this->router = $router;
    }

    public function load(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // You may want to make a custom query to fill the calendar
        /*
        $calendar->addEvent(new Event(
            'Event 1',
            new \DateTime('Tuesday this week'),
            new \DateTime('Wednesdays this week')
        ));

        // If the end date is null or not defined, it creates a all day event
        $calendar->addEvent(new Event(
            'All day event',
            new \DateTime('Friday this week')
        ));*/

        // Modify the query to fit to your entity and needs
        // Change Evenement.beginAt by your start date property
        /*$Evenements = $this->EvenementRepository
            ->createQueryBuilder('Evenement')
            ->where('Evenement.beginAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;*/
        //dans la requête du dessus , on n'a pas de champs beginAt en bdd
        // je pense pas qu'on puisse trouver un événement qui sorte des dates du calendrier , donc on va
        // faire plus simple
        
        $Evenements = $this->EvenementRepository->findAll();

        foreach ($Evenements as $Evenement) {
            // this create the events with your data (here Evenement data) to fill calendar
           /*$EvenementEvent = new Event(
                $Evenement->getNom(),
                $Evenement->getBeginAt(),
                $Evenement->getEndAt() // If the end date is null or not defined, a all day event is created.
            );*/

            foreach($Evenement->getPeriode() as $periode)
            {
                $EvenementEvent = new Event(
                    $Evenement->getNom(),
                    $periode->getDebut(),
                    $periode->getFin()
                );
                

                
                // on va adataper la couleur au domaine de l'événement

                $backgroundColor = 'blue';
                $borderColor = 'blue';
                
                switch($Evenement->getDomaine())
                {
                    case "Métiers de la construction durable , du bâtiment et des travaux publics":
                        $backgroundColor = '#B6B6B6';
                        $borderColor = '#B6B6B6';
                        break ;

                    case "Métiers de la relation client":
                        $backgroundColor = '#4BECE7';
                        $borderColor = '#4BECE7';
                        break ;

                    case "Métiers de la gestion administrative, du transport et de la logistique":
                        $backgroundColor = '#9929E7';
                        $borderColor = '#9929E7';
                        break ;
                        
                     case "Métiers des industries graphiques et de la communication":
                        $backgroundColor = '#FF4D04';
                        $borderColor = '#FF4D04';
                        break ;
                    
                     case 'Métiers des études et de la modélisation numérique du bâtiment':
                        $backgroundColor = '#255490';
                        $borderColor = '#255490';
                        break ;
                    
                    case "Métiers de l'alimention":
                        $backgroundColor = '#F9B308';
                        $borderColor = '#F9B308';
                        break ;
                    
                        
                    case "Métiers de la beauté et du bien-être":
                        $backgroundColor = '#FE02D0';
                        $borderColor = '#FE02D0';
                        break ;
                    

                    case "Métiers de l'aéronautique":
                        $backgroundColor = '#C6D3D2';
                        $borderColor = '#C6D3D2';
                        break ;
                    
                        
                    case "Métiers de l\'hôtellerie-restauration":
                        $backgroundColor = '#B1DBEC';
                        $borderColor = '#B1DBEC';
                        break ;
                    
                    case "Métiers du bois":
                        $backgroundColor = '#582900';
                        $borderColor = '#582900';
                        break ;

                    case "Métiers du pilotage d\'installations automatisées":
                        $backgroundColor = '#244956';
                        $borderColor = '#244956';
                        break ;
                    
                    case "Métiers de la maintenance":
                        $backgroundColor = '#000000';
                        $borderColor = '#000000';
                        break ;
                    
                    case "Métiers de la réalisation de produits mécaniques":
                        $backgroundColor = '#7F7473';
                        $borderColor = '#7F7473';
                        break ;
                    
                    case "Métiers du numérique et de la transition énergétique":
                        $backgroundColor = '#0CF950';
                        $borderColor = '0CF950';
                        break ;
                    
                     case "Autre":
                        $backgroundColor = 'blue';
                        $borderColor = 'blue';
                        break ;   
                }

                $EvenementEvent->setOptions([
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $borderColor,
                ]);

                $EvenementEvent->addOption(
                    'url',
                    $this->router->generate('show_evenement', [
                        'id' => $Evenement->getId(),
                    ])
                );

                $calendar->addEvent($EvenementEvent);
            }

            

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            /*
            $EvenementEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $EvenementEvent->addOption(
                'url',
                $this->router->generate('show_evenement', [
                    'id' => $Evenement->getId(),
                ])
            );
            */
            // finally, add the event to the CalendarEvent to fill the calendar
            //$calendar->addEvent($EvenementEvent);
            
        }
        
    }
}