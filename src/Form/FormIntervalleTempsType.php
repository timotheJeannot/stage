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
            ->add('debut',DateTimeType::class)/*,[
				'date_widget'=>'single_text'
			])*/
            ->add('fin',DateTimeType::class)
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
