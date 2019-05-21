<?php

namespace App\Form;

use App\Entity\IntervalleTemps;
use App\Form\FormIntervalleTempsType;
use App\Form\IntervalleTempsTrieType;
use App\Form\FormEvenementDomaineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FormTrieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domaine',CheckboxType::class, [
                //'label'    => 'domaine',
                'required' => false,
            ])
            /*->add('listeFM',FormEvenementDomaineType::class);*/
            ->add('listeFM',CollectionType::class, 
			[
            'entry_type' => FormEvenementDomaineType::class,
			'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete'  => true,
            ])
            ->add('date',CheckboxType::class, [
                'label'    => 'Date de publication',
                'required' => false,
            ])
            ->add('periode',CollectionType::class, 
			[
            'entry_type' => IntervalleTempsTrieType::class,
			'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete'  => true,
            ])
            ->add('date2',CheckboxType::class, [
                'label'    => 'Date de l\'événement',
                'required' => false,
            ])
            ->add('periode2',CollectionType::class, 
			[
            'entry_type' => IntervalleTempsTrieType::class,
            'entry_options' => ['label' => false],
            //'data_class' =>  IntervalleTemps::class,
            //'auto_initialize' => true,
            'allow_add' => true,
            'allow_delete'  => true,
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
