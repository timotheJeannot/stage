<?php

namespace App\Repository;

use App\Entity\IntervalleTemps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IntervalleTemps|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntervalleTemps|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntervalleTemps[]    findAll()
 * @method IntervalleTemps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntervalleTempsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IntervalleTemps::class);
    }

    // /**
    //  * @return IntervalleTemps[] Returns an array of IntervalleTemps objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IntervalleTemps
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
