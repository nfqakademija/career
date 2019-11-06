<?php

namespace App\Repository;

use App\Entity\CriteriaChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CriteriaChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CriteriaChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CriteriaChoice[]    findAll()
 * @method CriteriaChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriteriaChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CriteriaChoice::class);
    }

    // /**
    //  * @return CriteriaChoice[] Returns an array of CriteriaChoice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CriteriaChoice
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
