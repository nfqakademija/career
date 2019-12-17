<?php

namespace App\Repository;

use App\Entity\Criteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Criteria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Criteria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Criteria[]    findAll()
 * @method Criteria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriteriaRepository extends ServiceEntityRepository
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * CriteriaRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Criteria::class);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @param Criteria $criteria
     * @throws ORMException
     */
    public function create(Criteria $criteria)
    {
        $this->entityManager->persist($criteria);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save()
    {
        $this->entityManager->flush();
    }
}
