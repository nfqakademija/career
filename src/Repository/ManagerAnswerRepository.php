<?php

namespace App\Repository;

use App\Entity\ManagerAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ManagerAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManagerAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManagerAnswer[]    findAll()
 * @method ManagerAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagerAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManagerAnswer::class);
    }

    // /**
    //  * @return ManagerAnswer[] Returns an array of ManagerAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ManagerAnswer
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
