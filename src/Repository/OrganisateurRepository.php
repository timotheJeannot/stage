<?php

namespace App\Repository;

use App\Entity\Organisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Organisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organisateur[]    findAll()
 * @method Organisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganisateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Organisateur::class);
    }

    // /**
    //  * @return Organisateur[] Returns an array of Organisateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Organisateur
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
