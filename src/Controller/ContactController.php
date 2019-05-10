<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index()
    {

       //https://codereviewvideos.com/course/symfony-4-beginners-tutorial/video/symfony-4-contact-form
       //https://codereviewvideos.com/course/symfony-4-beginners-tutorial/video/send-email-symfony-4
       //https://symfony.com/doc/current/email.html 

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    // ici  il va falloir gérer une autre route avec l'id d'un événement ou d'un article
    // avec un autre type de formulaire 
}
