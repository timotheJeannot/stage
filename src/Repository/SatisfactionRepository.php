<?php

namespace App\Repository;

use App\Entity\Satisfaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Satisfaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Satisfaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Satisfaction[]    findAll()
 * @method Satisfaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SatisfactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Satisfaction::class);
    }

    // /**
    //  * @return Satisfaction[] Returns an array of Satisfaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Satisfaction
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // cette fonction va vérifier si l'inscrit à déja répondu au questionnaire de satisfaction
    public function findEvenementInscrit($idInscrit,$idEvenement)
    {
        return $this->createQueryBuilder('s')
                ->join('s.inscrit','i','WITH')
                ->join('s.evenement','e','WITH')
                ->where('i.id = :idInscrit')
                ->setParameter('idInscrit',$idInscrit)
                ->andWhere('e.id = :idEvenement')
                ->setParameter('idEvenement',$idEvenement)
                ->getQuery()
                ->getResult();
        
    }
}
