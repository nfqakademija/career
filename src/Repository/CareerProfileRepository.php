<?php

namespace App\Repository;

use App\Entity\CareerProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CareerProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerProfile[]    findAll()
 * @method CareerProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CareerProfile::class);
    }

    // /**
    //  * @return CareerProfile[] Returns an array of CareerProfile objects
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
    public function findOneBySomeField($value): ?CareerProfile
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
