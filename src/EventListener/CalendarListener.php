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