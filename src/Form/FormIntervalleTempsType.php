<?php

namespace App\Form;

use App\Entity\IntervalleTemps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FormIntervalleTempsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut',DateTimeType::class,[
                //'data'=> new \DateTime(),
                // On initialise le DateTime dans l'entity plûtot car sinon quand
                // on fait des modifications d'événements , ca supprime les anciennes périodes
            ])
            ->add('fin',DateTimeType::class,[
                //'data'=> new \DateTime(),
            ])
            //->add('evenements')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IntervalleTemps::class,
        ]);
    }
}
