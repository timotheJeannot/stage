<?php

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\IntervalleTemps;
use Symfony\Component\Form\Form;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    // /**
    //  * @return Evenement[] Returns an array of Evenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
    public function findByIntervalleTemps1(IntervalleTemps $periode)
    {
        return $this->createQueryBuilder('e')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();

        
    }

    public function findByIntervalleTemps2(IntervalleTemps $periode)
    {
        return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->where('i.debut >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('i.fin <= :fin')
                    ->setParameter('fin', $periode->getFin())

                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();

        
    }

    public function trie(Form $form)
    {
        $formData = $form->getData();
        if($formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
                // au moin un élément a été cocher dans la liste famille de métier
                // on va initialiser un array contenant les familles de métier
                //pour faire ce qui est dans ce lien ensuite
                //https://stackoverflow.com/questions/8270134/checking-value-in-an-array-inside-one-sql-query-with-where-clause
                $listeFM = [];
                foreach($formData['listeFM'] as $key)
                {
                    if ($key)
                    {
                        dump($key);
                        echo 'banzai'.'<br>';
                    }
                }
            }
        }
        
        // il faut déja commencer par tester si les 3 sont == true puis si deux sont == true puis si un == true
        // en tout il doit y avoir 8 cas en comptant le find all si tout les cases sont décocher
        if($formData['date2'] && $formData['date'] && $formData['domaine'])
        {

        }
        // autres cas ici ..
        if($formData['date2'] )
		{
            $periode = $formData['periode2'][0];
            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->where('i.debut >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('i.fin <= :fin')
                    ->setParameter('fin', $periode->getFin())

                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
        if($formData['date'] )
        {
            $periode = $formData['periode'][0];
            return $this->createQueryBuilder('e')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
        if($formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
                // au moin un élément a été cocher dans la liste famille de métier
                dump($formData['listeFM']);
                echo 'test43<br>';
            }
            else
            {
                // rien n'a été cocher dans la liste des familles des métiers
                echo'test44<br>';
                
            }
        }
        // ici faire un find all si rien n'a été cocher
    }
}
