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
        // $product = new Product();
        // $manager->persist($product);

        $Utilisateur = new Utilisateur();
        //$hash = "salut";
        //$hash = $encoder->encodePassword($Utilisateur,"3zHtV7U7n");
        //$Utilisateur->setPassword($hash);
        $Utilisateur->setPassword($this->passwordEncoder->encodePassword($Utilisateur,"3zHtV7U7n"));

        $Utilisateur->setEmail("administrateur@gmail.com");

        $Utilisateur->setRoles(['ROLE_ADMIN']);

        

        $manager->persist($Utilisateur);
        $manager->flush();
    }
}
