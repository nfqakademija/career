<?php

namespace App\Repository;

use App\Entity\CareerProfile;
use App\Entity\Criteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CareerProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerProfile[]    findAll()
 * @method CareerProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerProfileRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Criteria::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(CareerProfile $careerProfile)
    {
        $this->entityManager->persist($careerProfile);
        $this->entityManager->flush();
    }
}
