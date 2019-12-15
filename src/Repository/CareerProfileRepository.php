<?php

namespace App\Repository;

use App\Entity\CareerProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CareerProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerProfile[]    findAll()
 * @method CareerProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerProfileRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    /**
     * CareerProfileRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CareerProfile::class);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @param CareerProfile $careerProfile
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(CareerProfile $careerProfile)
    {
        $this->entityManager->persist($careerProfile);
        $this->entityManager->flush();
    }
}
