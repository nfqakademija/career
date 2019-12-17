<?php

namespace App\Repository;

use App\Entity\CareerForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CareerForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerForm[]    findAll()
 * @method CareerForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerFormRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    /**
     * CareerFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CareerForm::class);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @param CareerForm $careerForm
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(CareerForm $careerForm)
    {
        $this->entityManager->persist($careerForm);
        $this->entityManager->flush();
    }
}
