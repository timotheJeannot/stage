<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactEvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // ce formulaire est utilisé pour envoyer un mail aux contacts des différents événements

        $builder
        ->add('nom',TextType::class,[
            'constraints' => new notBlank(),
        ])
        ->add('prenom',TextType::class,[
            'constraints' => new notBlank(),
        ])
        ->add('email',TextType::class,[
            'constraints' => [new notBlank(),
                             new Email(),
            ],

        ])
        ->add('contenu',TextareaType::class,[
            'constraints' => new notBlank(),
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
