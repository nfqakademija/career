<?php

namespace App\Repository;

use App\Entity\UserAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAnswer[]    findAll()
 * @method UserAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAnswerRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserAnswer::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(UserAnswer $userAnswer)
    {
        $this->entityManager->persist($userAnswer);
    }
}
