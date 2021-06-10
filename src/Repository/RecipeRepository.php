<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\RecipeLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\Mapping as ORM;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * Renvoie les X dernières recettes publiées
     *
     * @param [Integer] $x
     * @return void
     */
        public function findLatest()
        {
            return $this ->createQuerybuilder('r')
                        ->orderBy('r.createdAt', "desc")
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult();
        }

    /**
     * Renvoie les 8 recettes les plus likées
     *
     * @return void
     */
    public function findMostPopular(){

            $qb = $this ->createQuerybuilder('r');
            return $qb  ->select('r')
                        ->innerJoin('r.recipeLikes', 'rl')
                        ->setMaxResults(8)
                        ->groupBy('r')
                        ->orderBy( $qb->expr()->countDistinct('r.id'), 'DESC')
                        ->getQuery()
                        ->getResult();

    }

    /**
     * Renvoie les recettes likées par l'utilisateur connecté
     *
     * @return void
     */
    public function findLikedByUser($userId){

        return $this  ->createQuerybuilder('r')
                        ->select('r')
                        ->innerJoin('r.recipeLikes', 'rl')
                        ->innerJoin('rl.user', 'u')
                        ->where('u.id = :userId')
                        ->setParameter('userId', $userId)
                        ->getQuery()
                        ->getResult();

    }

    // /**
    //  * @return Recipe[] Returns an array of Recipe objects
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
    public function findOneBySomeField($value): ?Recipe
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
