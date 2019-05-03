<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\FormAdminType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecurityController extends AbstractController
{

    /**
     * @Route("/inscription_admin", name="security_registration_admin")
     */
    public function registration()
    {
        $admin = new Admin();

        $form = $this->createForm(FormAdminType::class,$admin);

        return $this->render("security/inscription_admin.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
