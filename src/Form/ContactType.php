<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //https://symfony.com/doc/current/reference/forms/types/choice.html
        $builder
            ->add('sujet' , ChoiceType::class ,[
                'choices'=> [
                    'Campus des métiers et des qualifications'=> 'Campus des métiers et des qualifications',
                    'Les plateformes technologiques' => 'Les plateformes technologiques',
                    'Les comités locaux école-entreprise' => 'Les comités locaux école-entreprise',
                    'Les référents école-entreprise en collège' => 'Les référents école-entreprise en collège',
                    'Les conventions'=> 'Les conventions',
                    'Le lycée des métiers' => 'Le lycée des métiers',
                    'Les conseillers entreprise pour l\'école ' => 'Les conseillers entreprise pour l\'école',
                ]
                
            ])
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
