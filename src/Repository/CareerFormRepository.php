<?php

namespace App\Repository;

use App\Entity\CareerForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CareerForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerForm[]    findAll()
 * @method CareerForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CareerForm::class);
    }

    // /**
    //  * @return CareerForm[] Returns an array of CareerForm objects
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
    public function findOneBySomeField($value): ?CareerForm
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
