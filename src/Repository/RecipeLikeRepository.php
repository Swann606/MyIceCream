<?php

namespace App\Repository;

use App\Entity\RecipeLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipeLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeLike[]    findAll()
 * @method RecipeLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeLike::class);
    }


    /**
     * Renvoie les 8 recettes les plus likées
     *
     * @return void
     */
    public function findMostLiked(){

        return $this  ->createQuerybuilder('r')
                        ->select('re.id')
                        ->innerJoin('r.recipe', 're')
                        ->setMaxResults(8)
                        ->orderBy('myCount', "desc")
                        ->getQuery()
                        ->getResult();

 /*                        return $this  ->createQuerybuilder('r')
                        ->select('r.recipe','count(r.recipe) as mycount')
                        ->orderBy('mycount', "desc")
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult(); */
    }

    // /**
    //  * @return RecipeLike[] Returns an array of RecipeLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipeLike
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
