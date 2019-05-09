<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //cette fonction a été fait par moi et n'a pas été généré par la cli
    public function findOrderByDate()
    {
        //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html

       /* return $this->createQueryBuilder('a')
           // ->orderBy('a.createdAt','ASC')
            ->getQuery()
            ->getOneOrNullResult()

            ;
        */
        //https://stackoverflow.com/questions/6635601/doctrine-limit-syntax-error
        return $this->getEntityManager()
                    ->createQuery(
                        'Select a from App:Article a ORDER BY a.createdAt DESC'
                    )
                    ->setMaxResults(10)
                    ->getResult();
        
    }
}
