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

    
    public function myFindAll()
    {
    
        return $this->getEntityManager()
                    ->createQuery(
                        'Select e from App:Evenement e ORDER BY e.PublishedAt DESC'
                    )
                    ->getResult();
        
    }

    public function trie(Form $form)
    {
        $formData = $form->getData();

        
        $listeFM = [];
        if($formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
                // au moin un élément a été cocher dans la liste famille de métier
                // on va initialiser un array contenant les familles de métier
               // pour faire la recherche sql dans le tableau avec in 
               
                for($i = 1 ; $i <= count($formData['listeFM'][0]) ; $i++)
                {
                    if ($formData['listeFM'][0][$i])
                    {
                        
                        switch ($i)
                        {

                            case 1:
                                $listeFM[] = 'Autre';
                                break;
                            case 2:
                                $listeFM[] = 'Métiers de la construction durable , du bâtiment et des travaux publics';
                                break;
                            case 3:
                                $listeFM[] = 'Métiers de la relation client';
                                break;
                            case 4:
                                $listeFM[] = 'Métiers de la gestion administrative, du transport et de la logistique';
                                break;
                            case 5:
                                $listeFM[] = 'Métiers des industries graphiques et de la communication';
                                break;    
                            case 6:
                                $listeFM[] = 'Métiers des études et de la modélisation numérique du bâtiment';
                                break;
                            case 7:
                                $listeFM[] = 'Métiers de l\'alimention';
                                break;
                            case 8:
                                $listeFM[] = 'Métiers de la beauté et du bien-être';
                                break;
                            case 9:
                                $listeFM[] = 'Métiers de l\'aéronautique';
                                break;
                            case 10:
                                $listeFM[] = 'Métiers de l\'hôtellerie-restauration';
                                break; 
                            case 11:
                                $listeFM[] = 'Métiers du bois';
                                break;
                            case 12:
                                $listeFM[] = 'Métiers du pilotage d\'installations automatisées';
                                break;
                            case 13:
                                $listeFM[] = 'Métiers de la maintenance';
                                break;
                            case 14:
                                $listeFM[] = 'Métiers de la réalisation de produits mécaniques';
                                break;     
                            case 15:
                                $listeFM[] = 'Métiers du numérique et de la transition énergétique';
                                break;       
                        }     
                    }
                }
                
                
            }
        }
        // il faut déja commencer par tester si les 3 sont == true puis si deux sont == true puis si un == true
        // en tout il doit y avoir 8 cas en comptant le find all si tout les cases sont décocher
        if($formData['date2'] && $formData['date'] && $formData['domaine'])
        {
           
            if($formData['listeFM'] != null)
            {
            // au moin un élément a été cocher dans la liste famille de métier
            // on ne ne fair rien sinon, car on rentrera dans le bon if après

            $periode2 = $formData['periode2'][0];
            $periode = $formData['periode'][0];

            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('i.debut >= :debut2')
                    ->setParameter('debut2', $periode2->getDebut())
                    ->andWhere('i.fin <= :fin2')
                    ->setParameter('fin2', $periode2->getFin())
                    ->andWhere('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }        
        }
        if($formData['date2'] && $formData['date'])
        {
            $periode2 = $formData['periode2'][0];
            $periode = $formData['periode'][0];
            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('i.debut >= :debut2')
                    ->setParameter('debut2', $periode2->getDebut())
                    ->andWhere('i.fin <= :fin2')
                    ->setParameter('fin2', $periode2->getFin())
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
        if($formData['date2'] && $formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
            // au moin un élément a été cocher dans la liste famille de métier
            // on ne ne fair rien sinon, car on rentrera dans le bon if après

            $periode2 = $formData['periode2'][0];

            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->where('i.debut >= :debut2')
                    ->setParameter('debut2', $periode2->getDebut())
                    ->andWhere('i.fin <= :fin2')
                    ->setParameter('fin2', $periode2->getFin())
                    ->andWhere('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }
        }
        if($formData['date'] && $formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
            // au moin un élément a été cocher dans la liste famille de métier
            // on ne ne fair rien sinon, car on rentrera dans le bon if après

            $periode = $formData['periode'][0];

            return $this->createQueryBuilder('e')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }
        }
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
                return $this->createQueryBuilder('e')
                    ->where('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }
            
        }
        // Rien n'a été cocher on retourne un MyFindAll()
        return $this->myFindAll();
    }

    // cette fonction est la même que myFindAll sauf qu'elle prend en compte en plus l'id de l'utilisateur
    // elle est utilisé pour la route mes_publications
    public function userMyFindAll($id)
    {
    
        
                return $this->createQueryBuilder('e')
                ->join('e.utilisateur','u','WITH')
                ->where('u.id = :idUser')
                ->setParameter('idUser',$id)
                ->orderBy('e.PublishedAt','DESC')
                ->getQuery()
                ->getResult();
        
    }

    // cette fonction est la même que trie sauf qu'elle prend en compte l'id de l'utilisateur courant en plus
    // elle est appellé dans la route mes_publications
    public function trieUser(Form $form , $id)
    {
        $formData = $form->getData();

        
        $listeFM = [];
        if($formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
                // au moin un élément a été cocher dans la liste famille de métier
                // on va initialiser un array contenant les familles de métier
               // pour faire la recherche sql dans le tableau avec in 
               
                for($i = 1 ; $i <= count($formData['listeFM'][0]) ; $i++)
                {
                    if ($formData['listeFM'][0][$i])
                    {
                        
                        switch ($i)
                        {

                            case 1:
                                $listeFM[] = 'Autre';
                                break;
                            case 2:
                                $listeFM[] = 'Métiers de la construction durable , du bâtiment et des travaux publics';
                                break;
                            case 3:
                                $listeFM[] = 'Métiers de la relation client';
                                break;
                            case 4:
                                $listeFM[] = 'Métiers de la gestion administrative, du transport et de la logistique';
                                break;
                            case 5:
                                $listeFM[] = 'Métiers des industries graphiques et de la communication';
                                break;    
                            case 6:
                                $listeFM[] = 'Métiers des études et de la modélisation numérique du bâtiment';
                                break;
                            case 7:
                                $listeFM[] = 'Métiers de l\'alimention';
                                break;
                            case 8:
                                $listeFM[] = 'Métiers de la beauté et du bien-être';
                                break;
                            case 9:
                                $listeFM[] = 'Métiers de l\'aéronautique';
                                break;
                            case 10:
                                $listeFM[] = 'Métiers de l\'hôtellerie-restauration';
                                break; 
                            case 11:
                                $listeFM[] = 'Métiers du bois';
                                break;
                            case 12:
                                $listeFM[] = 'Métiers du pilotage d\'installations automatisées';
                                break;
                            case 13:
                                $listeFM[] = 'Métiers de la maintenance';
                                break;
                            case 14:
                                $listeFM[] = 'Métiers de la réalisation de produits mécaniques';
                                break;     
                            case 15:
                                $listeFM[] = 'Métiers du numérique et de la transition énergétique';
                                break;       
                        }     
                    }
                }
                
                
            }
        }
        // il faut déja commencer par tester si les 3 sont == true puis si deux sont == true puis si un == true
        // en tout il doit y avoir 8 cas en comptant le find all si tout les cases sont décocher
        if($formData['date2'] && $formData['date'] && $formData['domaine'])
        {
           
            if($formData['listeFM'] != null)
            {
            // au moin un élément a été cocher dans la liste famille de métier
            // on ne ne fair rien sinon, car on rentrera dans le bon if après

            $periode2 = $formData['periode2'][0];
            $periode = $formData['periode'][0];

            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->join('e.utilisateur','u','WITH')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('i.debut >= :debut2')
                    ->setParameter('debut2', $periode2->getDebut())
                    ->andWhere('i.fin <= :fin2')
                    ->setParameter('fin2', $periode2->getFin())
                    ->andWhere('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }        
        }
        if($formData['date2'] && $formData['date'])
        {
            $periode2 = $formData['periode2'][0];
            $periode = $formData['periode'][0];
            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->join('e.utilisateur','u','WITH')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('i.debut >= :debut2')
                    ->setParameter('debut2', $periode2->getDebut())
                    ->andWhere('i.fin <= :fin2')
                    ->setParameter('fin2', $periode2->getFin())
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
        if($formData['date2'] && $formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
            // au moin un élément a été cocher dans la liste famille de métier
            // on ne ne fair rien sinon, car on rentrera dans le bon if après

            $periode2 = $formData['periode2'][0];

            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->join('e.utilisateur','u','WITH')
                    ->where('i.debut >= :debut2')
                    ->setParameter('debut2', $periode2->getDebut())
                    ->andWhere('i.fin <= :fin2')
                    ->setParameter('fin2', $periode2->getFin())
                    ->andWhere('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }
        }
        if($formData['date'] && $formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
            // au moin un élément a été cocher dans la liste famille de métier
            // on ne ne fair rien sinon, car on rentrera dans le bon if après

            $periode = $formData['periode'][0];

            return $this->createQueryBuilder('e')
                    ->join('e.utilisateur','u','WITH')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }
        }
        if($formData['date2'] )
		{
            $periode = $formData['periode2'][0];
            return $this->createQueryBuilder('e')
                    ->join('e.periode','i','WITH')
                    ->join('e.utilisateur','u','WITH')
                    ->where('i.debut >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('i.fin <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
        if($formData['date'] )
        {
            $periode = $formData['periode'][0];
            return $this->createQueryBuilder('e')
                    ->join('e.utilisateur','u','WITH')
                    ->where('e.PublishedAt >= :debut')
                    ->setParameter('debut', $periode->getDebut())
                    ->andWhere('e.PublishedAt <= :fin')
                    ->setParameter('fin', $periode->getFin())
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
        }
        if($formData['domaine'])
        {
            if($formData['listeFM'] != null)
            {
                // au moin un élément a été cocher dans la liste famille de métier
                return $this->createQueryBuilder('e')
                    ->join('e.utilisateur','u','WITH')
                    ->where('e.domaine IN (:tab)')
                    ->setParameter('tab', $listeFM)
                    ->andWhere('u.id = :idUser')
                    ->setParameter('idUser',$id)
                    ->orderBy('e.PublishedAt','DESC')
                    ->getQuery()
                    ->getResult();
            }
            
        }
        // Rien n'a été cocher on retourne un userMyFindAll()
        return $this->userMyFindAll($id);
    }
}
