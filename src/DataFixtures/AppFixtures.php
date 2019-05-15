<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager )
    {
        // php bin/console doctrine:fixtures:load --append

        printf("Bienvenue dans le script pour insérer un administrateur , les accents ne sont pas supporté.\nSi vous voulez utilisé des accents vous allez devoir modifier le profil depusi le site \n\n");

        printf("Renseigner un email pour l'administrateur !!\n\n");
        $email = fgets(STDIN);
        $email = trim($email);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            printf("Vous n'avez pas rentrer une adresse mail valide, relancer le script pour réesayer\n");
        }
        else
        {
            printf("\nRenseigner un Mot de passe pour l'administrateur !!\nLes espaces blancs en début et fin de chaine de caractères seront supprimé. Le mot de passe doit faire 8 caractères avec au moin un chiffre, au moin une majuscule et au moin un caractére spécial (#, @, &...).\nSi vous n'avez pas d'idée visiter ces pages : https://www.motdepasse.xyz/ \n https://wiki.epfl.ch/secure-it/questcequunbonmotdepasse\n\n");
            $mdp = fgets(STDIN);
            $mdp = trim($mdp);

            $test = true;
            
            if(strlen($mdp)<8)
            {
                printf("votre mot de passe fait moin de 8 caractères\n");
                $test = false;
            } 
            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $mdp)) {
                //https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2917331-controlez-les-mots-de-passe
            }
            else {
                printf("Mot de passe non conforme \n");
                $test = false;
            }

            if($test)
            {
                printf("Confirmer le mot de passe.\n\n");
                $confirmMdp = fgets(STDIN);
                $confirmMdp = trim($confirmMdp);

                if($confirmMdp == $mdp)
                {
                    $Utilisateur = new Utilisateur();
                    //$hash = $encoder->encodePassword($Utilisateur,"3zHtV7U7n");
                    //$Utilisateur->setPassword($hash);
                    //$Utilisateur->setPassword($this->passwordEncoder->encodePassword($Utilisateur,"6GnJeP46w"));
                    $Utilisateur->setPassword($this->passwordEncoder->encodePassword($Utilisateur,$mdp));

                    //$Utilisateur->setEmail("administrateur@gmail.com");
                    $Utilisateur->setEmail($email);

                    $Utilisateur->setRoles(['ROLE_ADMIN']);

                    //appeller le validateur sur $Utilisateur aurait peut être été
                    //plus simple et plus propre

                    printf("Veuiller rentrer un nom \n\n");
                    $nom = fgets(STDIN);
                    $nom = trim($nom);

                    printf("Veuillez rentrer un prénom \n\n");
                    $prenom = fgets(STDIN);
                    $prenom = trim($prenom);

                    printf("Le service de l'adminitrateur est celui de Besançon automatiquement");
                    $Utilisateur->setNom($nom);
                    $Utilisateur->setPrenom($prenom);
                    $Utilisateur->setService('Besançon');

                    $manager->persist($Utilisateur);
                    $manager->flush();
                }
                else
                {
                    printf("Vous n'avez pas rentrer le même mot de passe, relancer le script pour réesayer\n");
                }
            }
            else
            {
                printf("Vos données ne peuvent pas être enregistré , relancer le script pour réesayer\n");
            }
        }    
    }
}
