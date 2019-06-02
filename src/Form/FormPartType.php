<?php

namespace App\Form;

use App\Entity\Part;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormPartType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('question')
            //->add('reponse',TextareaType::class)
            //->add('satisfaction')
        ;

        // https://symfony.com/doc/current/form/dynamic_form_modification.html
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $part = $event->getData();
            $form = $event->getForm();
            // on va récupèrer la question de l'événement
            
           
            foreach($part->getSatisfaction()->getEvenement()->getQuestions() as $key)
            {
                if($key->getContenu() == $part->getQuestion())
                {
                    // on est censé rentrer une et une seule fois dans ce if
                    // il faut vérifier que il n'y est pas deux fois la même question pour un événement

                    // on va regarder si des réponses sont associéà la question
                    
                    if($key->getReponses()[0] != null)
                    {
                        // on va récuper les réponses et insérer un ChoiceType
                        $array = [];
                        foreach($key->getReponses() as $key2)
                        {
                            $reponse = $key2->getContenu();
                            $array["$reponse"] = "$reponse";
                        }
                        $form->add('reponse',ChoiceType::class, [
                            'choices'  => $array,
                            ]
                        );
                    }
                    else
                    {
                        $form->add('reponse',TextareaType::class);
                    }
                }
            }

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Part::class,
        ]);
    }
}
