<?php

namespace App\Repository;

use App\Entity\Article;
use Symfony\Component\Form\Form;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findOrderByDate()
    {
    
        return $this->getEntityManager()
                    ->createQuery(
                        'Select a from App:Article a ORDER BY a.createdAt DESC'
                    )
                    ->setMaxResults(10)
                    ->getResult();
        
    }

    public function myFindAll()
    {
    
        return $this->getEntityManager()
                    ->createQuery(
                        'Select a from App:Article a ORDER BY a.createdAt DESC'
                    )
                    ->getResult();
        
    }

    public function trie(Form $form)
    {
        $formData = $form->getData();
        if($formData['date'] )
        {
            $periode = $formData['periode'][0];
            return $this->createQueryBuilder('a')
                    ->where('a.createdAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('a.createdAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->orderBy('a.createdAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
    }
}
