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
