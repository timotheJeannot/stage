<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//https://github.com/tattali/CalendarBundle/blob/HEAD/src/Resources/doc/doctrine-crud.md#full-listener

// ce fichier a été généré avec make:crud Evenement , pour voir tout ce que ca a fait visiter le lien au dessus

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{

    /**
     * @Route("/calendar", name="evenement_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('evenement/calendar.html.twig');
    }
}
