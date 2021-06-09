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


    /* public function findRecipeLikedByUser($userId)
    {
        $qb = $this->createQueryBuilder('r')
                    ->Select('r')
                    ->Join('r.recipeLike','rl')
                    ->Join('rl.user', 'u')
                    ->Where('rl.user_id = $userId')
                    ->getQuery()
                    ->getResult();

                    dump($qb);
    }    */


    /**
     * Renvoie les X dernières recettes publiées
     *
     * @param [Integer] $x
     * @return void
     */
        public function findLatest($x)
        {
            return $this ->createQuerybuilder('r')
                        ->orderBy('r.createdAt', "desc")
                        ->setMaxResults($x)
                        ->getQuery()
                        ->getResult();
        }

        /**
         * Renvoie les X recettes avec le plus de like          *
         * @param [Integer] $x
         * @return void
         */
        public function findMostPopular($x){
                $qb= $this ->createQuerybuilder('r')
                            ->select($qb->expr()->countDistinct('c.id'))
                            ->orderBy('r.recipe_like', "asc")
                            ->setMaxResults($x)
                            ->getQuery()
                            ->getResult();

                return $qb;
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
