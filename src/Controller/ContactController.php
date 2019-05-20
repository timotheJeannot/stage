<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Evenement;
use App\Form\ContactType;
use App\Form\ContactEvenementType;
use App\Repository\ContactRepository;
use App\Repository\EvenementRepository;
use App\Repository\OrganisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

       //https://codereviewvideos.com/course/symfony-4-beginners-tutorial/video/symfony-4-contact-form
       //https://codereviewvideos.com/course/symfony-4-beginners-tutorial/video/send-email-symfony-4
       //https://symfony.com/doc/current/email.html 

       $form = $this->createForm(ContactType::class);

       $form->handleRequest($request);


       if ($form->isSubmitted() && $form->isValid()) 
       {
    
            $contactFormData = $form->getData();

            $somme = $contactFormData['verification'];

            if($somme == $contactFormData['nb1'] + $contactFormData['nb2'])
            {

                $message = (new \Swift_Message($contactFormData['sujet']))
                        ->setFrom($contactFormData['email'])
                        ->setTo('timothe.jeannot@gmail.com')
                        ->setBody(
                        $contactFormData['contenu'],
                        'text/html'
                        )
                    ;
                
                $mailer->send($message);

                $this->addFlash('success', 'It sent!');

                return $this->redirectToRoute('accueil');
            }

       }
       $nb1 = rand(0,10);
       $nb2 = rand(0,10);
       return $this->render('site/contact.html.twig', [
        'form'=> $form->createView(),
        'nb1' => $nb1,
        'nb2' =>$nb2,
        ]);

    }

    /**
     * @Route("/contact/{idContact}/evenement/{idEvenement}", name="contactEvenement")
     */
    public function contactEvenement(Request $request, \Swift_Mailer $mailer , $idContact , $idEvenement , EvenementRepository $repositoryE , ContactRepository $repositoryC)
    {
       $form = $this->createForm(ContactEvenementType::class);

       $form->handleRequest($request);

       $evenement = $repositoryE->find($idEvenement);

       $contact = $repositoryC->find($idContact);

       if ($form->isSubmitted() && $form->isValid()) 
       {
    
            $contactFormData = $form->getData();
            $somme = $contactFormData['verification'];

            if($somme == $contactFormData['nb1'] + $contactFormData['nb2'])
            {
                
                $message = (new \Swift_Message($evenement->getNom()))
                        ->setFrom($contactFormData['email'])
                        ->setTo($contact->getMail())
                        ->setBody(
                        $contactFormData['contenu'],
                        'text/html'
                        )
                    ;
                
                $mailer->send($message);

                $this->addFlash('success', 'It sent!');

                return $this->redirectToRoute('accueil');
            
            }
       }
       // on va générer deux digit pour que l'utilisateur fasse une somme et vérifier que ce ne soit pas un robot
       $nb1 = rand(0,10);
       $nb2 = rand(0,10);

       return $this->render('site/contactEvenement.html.twig', [
        'form'=> $form->createView(),
        'evenement' => $evenement,
        'contact' => $contact,
        'nb1' => $nb1,
        'nb2' =>$nb2,
        ]);
    }

    /**
     * @Route("/contact/organisateur/{idOrganisateur}/{idEvenement}", name="contactOrganisateurEvenement")
     */
    public function contactOrganisateurEvenement(Request $request, \Swift_Mailer $mailer , $idOrganisateur , $idEvenement , EvenementRepository $repositoryE , OrganisateurRepository $repositoryO)
    {
       $form = $this->createForm(ContactEvenementType::class);

       $form->handleRequest($request);

       $evenement = $repositoryE->find($idEvenement);

       $contact = $repositoryO->find($idOrganisateur);

       if ($form->isSubmitted() && $form->isValid()) 
       {
    
            $contactFormData = $form->getData();

            $somme = $contactFormData['verification'];

            if($somme == $contactFormData['nb1'] + $contactFormData['nb2'])
            {

                $message = (new \Swift_Message($evenement->getNom()))
                        ->setFrom($contactFormData['email'])
                        ->setTo($contact->getMail())
                        ->setBody(
                        $contactFormData['contenu'],
                        'text/html'
                        )
                    ;
                
                $mailer->send($message);

                $this->addFlash('success', 'It sent!');

                return $this->redirectToRoute('accueil');
            }

       }
       $nb1 = rand(0,10);
       $nb2 = rand(0,10);
       return $this->render('site/contactOrganisateurEvenement.html.twig', [
        'form'=> $form->createView(),
        'evenement' => $evenement,
        'contact' => $contact,
        'nb1' => $nb1,
        'nb2' =>$nb2,
        ]);
    }


}
