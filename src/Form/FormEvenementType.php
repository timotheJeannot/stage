<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FormEvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')//	,['attr' => ['placeholder'=> "nom de l'événement"] ,  'label'=> "Nom"])
            ->add('description')//,['attr' => ['placeholder'=> "Description de l'événement"],  'label'=> "Description"])
            ->add('image')//,['attr' => ['placeholder'=> "Url de l'image"],  'label'=> "Image"])
            //->add('estDans')
            ->add('periode', CollectionType::class, 
			[
            'entry_type' => FormIntervalleTempsType::class,
			'entry_options' => ['label' => false],
			'allow_add' => true,
			])
				
				
				
				
            ->add('lieu',FormLieuType::class)
            ->add('organisateurs',CollectionType::class, 
			[
            'entry_type' => FormOrganisateurType::class,
			'entry_options' => ['label' => false],
			'allow_add' => true,
			])
			 // ->add('PublishedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
			'csrf_protection' => false,
        ]);
    }
}
