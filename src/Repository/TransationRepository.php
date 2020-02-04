<?php

namespace App\Repository;

use App\Entity\Transation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Transation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transation[]    findAll()
 * @method Transation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transation::class);
    }

    // /**
    //  * @return Transation[] Returns an array of Transation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
