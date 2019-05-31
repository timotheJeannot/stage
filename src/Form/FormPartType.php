<?php

namespace App\Form;

use App\Entity\Part;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormPartType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('question')
            ->add('reponse',TextareaType::class)
            //->add('satisfaction')
        ;

        // https://symfony.com/doc/current/form/dynamic_form_modification.html
        /*$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {

        });*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Part::class,
        ]);
    }
}
