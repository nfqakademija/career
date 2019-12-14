<?php

namespace App\Repository;

use App\Entity\ManagerAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ManagerAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManagerAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManagerAnswer[]    findAll()
 * @method ManagerAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagerAnswerRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ManagerAnswer::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(ManagerAnswer $managerAnswer)
    {
        $this->entityManager->persist($managerAnswer);
        $this->entityManager->flush();
    }
}
