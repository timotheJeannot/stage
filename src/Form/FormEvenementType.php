<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('domaine',ChoiceType::class ,[
                'choices'=> [
                    'Autre'=>'Autre',
                    'Métiers de la construction durable , du bâtiment et des travaux publics' => 'Métiers de la construction durable , du bâtiment et des travaux publics',
                    'Métiers de la relation client' => 'Métiers de la relation client',
                    'Métiers de la gestion administrative, du transport et de la logistique' => 'Métiers de la gestion administrative, du transport et de la logistique',
                    'Métiers des industries graphiques et de la communication'=> 'Métiers des industries graphiques et de la communication',
                    'Métiers des études et de la modélisation numérique du bâtiment' =>'Métiers des études et de la modélisation numérique du bâtiment',
                    'Métiers de l\'alimention ' => 'Métier de l\'alimention ',
                    'Métiers de la beauté et du bien-être' =>'Métiers de la beauté et du bien-être',
                    'Métiers de l\'aéronautique' => 'Métiers de l\'aéronautique',
                    'Métiers de l\'hôtellerie-restauration' => 'Métier de l\'hôtellerie-restauration',
                    'Métiers du bois' => 'Métiers du bois',
                    'Métiers du pilotage d\'installations automatisées'=>'Métiers du pilotage d\'installations automatisées',
                    'Métiers de la maintenance'=> 'Métiers de la maintenance',
                    'Métiers de la réalisation de produits mécaniques'=> 'Métiers de la réalisation de produits mécaniques',
                    'Métiers du numérique et de la transition énergétique'=> 'Métiers du numérique et de la transition énergétique',
                ]
                
            ])
            ->add('periode', CollectionType::class, 
			[
            'entry_type' => FormIntervalleTempsType::class,
			'entry_options' => ['label' => false],
			'allow_add' => true,
			])
            ->add('organisateurs',CollectionType::class, 
			[
            'entry_type' => FormOrganisateurType::class,
			'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
			'by_reference' => false,
            'prototype' => true,
            
            ])
            ->add('lieu',FormLieuType::class)
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
