<?php

namespace App\Repository;

use App\Entity\ListeContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ListeContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeContact[]    findAll()
 * @method ListeContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ListeContact::class);
    }

    // /**
    //  * @return ListeContact[] Returns an array of ListeContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListeContact
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
