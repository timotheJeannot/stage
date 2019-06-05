<?php
// src/Command/sendSatisfaction.php
namespace App\Command;

use App\Repository\InscritRepository;
use App\Repository\EvenementRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class sendSatisfaction extends Command  
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send-satisfaction';

    private $repoEve ;

    private $repoInscrit ;

    private $mailer;

    private $params;

    private $manager;

    public function __construct(EvenementRepository $repoEve , InscritRepository $repoInscrit, \Swift_Mailer $mailer, ParameterBagInterface $params , ObjectManager $manager)
    {
        $this->repoEve = $repoEve;
        $this->repoInscrit = $repoInscrit;
        $this->mailer = $mailer;
        $this->params = $params;
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Envoyer les formulaires de satisfaction')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Cette commande va envoyer un mail contenant un lien vers un formulaire de satisfactions.
Ce mail est envoyé aux aux inscrits des événements qui sont passé et dont le formulaire
de satisfaction n\'a pas été envoyé            ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)//, EvenementRepository $repoEve , InscritRepository $repoInscrit)
    {
        $output->writeln('amazing !');
        $evenements = $this->repoEve->findAll();
        foreach($evenements as $key)
        {
            if($key->isFinish() && !$key->getSurvey() )
            {
                $output->writeln($key->getNom().' est fini et le formulaire de satisfaction est à envoyé !   ');

                // on récupère les inscrits à l'événement
                $inscrits = $this->repoInscrit->findByIdEvenement($key->getId());

                $output->writeln('///////////');
                foreach($inscrits as $key2)
                {
                    $output->writeln($key2->getPrenom().' '.$key2->getNom().' est inscrit à '.$key->getNom());

                    // on va envoyer un mail

                    $message = (new \Swift_Message('enquête de satisfaction sur l\'événement : '.$key->getNom()))
                        ->setFrom('timothe.jeannot@gmail.com')
                        ->setTo($key2->getMail())
                        ->setBody(
                            /*$this->params->get('templating')->render(
                                'site/satisfaction.html.twig'
                            ),*/
                            '<html>' .
                            ' <head></head>' .
                            ' <body>' .
                            'Merci d\'avoir participer à '.$key->getNom().'.
                            pour répondre à l\'enquête de satisfaction veuillez cliquer sur le lien :<br><br> ' .
                            '<a href="127.0.0.1">Lien vers l\'enquête</a><br><br>ceci est un mail envoyé automatiquement'.
                            ' </body>' .
                            '</html>',
                            'text/html'
                            /*'Bonjour
                        
Merci d\'avoir participer à '.$key->getNom().'.
pour répondre à l\'enquête de satisfaction veuillez cliquer sur le lien : '.'

ceci est un mail envoyé automatiquement'*/
                        )
                    ;
                
                    $this->mailer->send($message);
                }
                // on modfie survey pour pas que les mails soient renvoyés à la prochaine éxécution de la commande
                $key->setSurvey(true);
                $this->manager->persist($key);
                $this->manager->flush();
                $output->writeln('///////////');
            }
        }
    }
}