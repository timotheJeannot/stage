<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\FormUtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request , ObjectManager $manager , UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new Utilisateur();
        $form = $this->createForm(FormUtilisateurType::class,$user);
        //https://github.com/symfony/symfony/issues/13663
        //https://github.com/symfony/symfony/issues/25697
        echo 'test1 <br><br>';
        $form->handleRequest($request);
        echo 'test2<br><br>';

        if($form->isSubmitted() && $form->isValid())
		{
            //echo 'test3 <br><br>';
            $user->setPassword($passwordEncoder->encodePassword($user,$user->getPassword()));
            $manager->persist($user);
            $manager->flush();

            return $this->render("site/accueil.html.twig");
        }

        return $this->render("security/inscription.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/liste_cm", name="liste_cm")
     */
    public function liste_cm(UtilisateurRepository $repoUser)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $repoUser->findAll();

        return $this->render("security/liste_cm.html.twig",[
            'users' => $users
        ]);        
    }

    /**
     * @Route("/suppression_cm/{id}", name="suppression_cm")
     */
    public function suppression(UtilisateurRepository $repoUser,$id, ObjectManager $manager )
    {
        //https://symfony.com/doc/current/security.html
        // voir la section securiting controllers and other code

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $repoUser->find($id);

        $manager->remove($user);
        $manager->flush();

        return $this->render("site/accueil.html.twig");        
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
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->render('accueil');
    }
}
