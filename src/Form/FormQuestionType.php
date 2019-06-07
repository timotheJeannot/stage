<?php

namespace App\Form;

use App\Entity\Question;
use App\Form\FormReponseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FormQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu')
            ->add('reponses', CollectionType::class, 
			[
            'entry_type' => FormReponseType::class,
			'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' =>true,
            'by_reference' => false,
			])
            //->add('evenement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
