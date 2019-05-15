<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // ce formulaire a été généré lors de l'intégration du calendrier. , il n'est, il me semble pas utile.
        $builder
            ->add('nom')
            ->add('description')
            ->add('image')
            ->add('PublishedAt')
            ->add('estDans')
            ->add('periode')
            ->add('lieu')
            ->add('organisateurs')
            ->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
