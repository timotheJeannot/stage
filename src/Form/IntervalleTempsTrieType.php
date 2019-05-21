<?php

namespace App\Form;

use App\Entity\IntervalleTemps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class IntervalleTempsTrieType extends AbstractType
{
    // ce formulaire est là pour pouvoir avoir des dates dont la valeur par défaut est la date du jour
    // dans le formulaire de trie des pages articles et événements.
    // Normalement on fait sa dans le constructeur de l'entity mais
    // le formulaire de trie n'appelle pas de constructeur d'entity
    // on ne peut pas le mettre dans FormIntervalleTempsType car
    // si on modifie un article la valeur de la date sera changé 
    // je n'ai pas trouvé d'autre solutions que de faire deux form intervalleTemps différents
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('debut',DateTimeType::class,[
            'data'=> new \DateTime('today',new \DateTimeZone('Europe/Paris')),
            
        ])
        ->add('fin', DateTimeType::class,[
            'data'=> new \DateTime('today',new \DateTimeZone('Europe/Paris')),
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IntervalleTemps::class,
        ]);
    }
}
