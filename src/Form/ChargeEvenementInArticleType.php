<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Evenement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Repository\EvenementRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChargeEvenementInArticleType extends AbstractType
{
    private $repoE;

    public function __construct(EvenementRepository $repoE)
    {
        $this->repoE = $repoE;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // https://symfony.com/doc/current/form/dynamic_form_modification.html
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();
            $evenements = $this->repoE->findAll();

           $array = [];

           foreach($evenements as $key)
           {
               $nom = $key->getNom();
               $idE = $key->getId();
               $array["$nom (id = $idE)"] = $key;
           }
           $form->add('evenement',ChoiceType::class, [
                //'class' => 'App\Entity\Evenement',
                'choices'  => $array,
                ]
            );

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           // 'data_class' => Article::class,
        ]);
    }
}
