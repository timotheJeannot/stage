<?php

namespace App\DataFixtures;

use App\Entity\Admin;
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

        $admin = new Admin();
        //$hash = "salut";
        //$hash = $encoder->encodePassword($admin,"3zHtV7U7n");
        //$admin->setPassword($hash);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin,"3zHtV7U7n"));

        $admin->setUsername("administrateur");

        

        $manager->persist($admin);
        $manager->flush();
    }
}
