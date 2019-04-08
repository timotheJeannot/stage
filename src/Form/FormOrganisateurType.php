<?php

namespace App\Form;

use App\Entity\Organisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FormOrganisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('siteWeb')
            ->add('mail')
            ->add('image')
            //->add('Evenement')
            ->add('contacts',CollectionType::class, 
			[
            'entry_type' => FormContactType::class,
			'entry_options' => ['label' => false],
			'allow_add' => true,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organisateur::class,
        ]);
    }
}
