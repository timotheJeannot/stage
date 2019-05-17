<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FormEvenementDomaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('1',CheckboxType::class, [
                'required' => false,
                'label' => 'Autre',
                'value' => 'Autre',
            ])
            ->add('2',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de la construction durable , du bâtiment et des travaux publics',
            ])
            ->add('3',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de la relation client',
            ])
            ->add('4',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de la gestion administrative, du transport et de la logistique',
            ])
            ->add('5',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers des industries graphiques et de la communication',
            ])
            ->add('6',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers des études et de la modélisation numérique du bâtiment',
            ])
            ->add('7',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de l\'alimention',
            ])
            ->add('8',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de la beauté et du bien-être',
            ])
            ->add('9',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de l\'aéronautique',
            ])
            ->add('10',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de l\'hôtellerie-restauration',
            ])
            ->add('11',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers du bois',
            ])
            ->add('12',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers du pilotage d\'installations automatisées',
            ])
            ->add('13',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de la maintenance',
            ])
            ->add('14',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers de la réalisation de produits mécaniques',
            ])
            ->add('15',CheckboxType::class, [
                'required' => false,
                'label' => 'Métiers du numérique et de la transition énergétique',
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
