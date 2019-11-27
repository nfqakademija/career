<?php

namespace App\Repository;

use App\Entity\Competence;
use App\Entity\Criteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Competence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competence[]    findAll()
 * @method Competence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Competence::class);
        $this->entityManager = $this->getEntityManager();
    }


    public function fetchApplicable()
    {
        $query = $this->entityManager->createQuery('SELECT id, title '
            . 'FROM App\Entity\Competence' . 'WHERE isApplicable = :isApplicable')->setParameter('isApplicable', 1);
        return $query->getResult();
    }
}
