<?php

namespace App\Form;

use App\Entity\Accueil;
use App\Form\FormInfoSiteType;
use App\Form\FormPartenairesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormAccueilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partenaires',FormPartenairesType::class)
            ->add('infoSite',FormInfoSiteType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accueil::class,
        ]);
    }
}
