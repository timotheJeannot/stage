<?php

namespace App\Repository;

use App\Entity\InfoSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InfoSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSite[]    findAll()
 * @method InfoSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InfoSite::class);
    }

    // /**
    //  * @return InfoSite[] Returns an array of InfoSite objects
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
    public function findOneBySomeField($value): ?InfoSite
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
