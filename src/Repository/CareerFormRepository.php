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


}
