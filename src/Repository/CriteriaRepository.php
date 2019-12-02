<?php

namespace App\Repository;

use App\Entity\Criteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Criteria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Criteria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Criteria[]    findAll()
 * @method Criteria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriteriaRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Criteria::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function fetchChoicesByCriteria(int $id, int $isApplicable = 1)
    {
        $query = $this->entityManager->createQuery(
            'SELECT ch.id, ch.title AS Choice '
            . 'FROM App\Entity\CriteriaChoice ch '
            . 'JOIN App\Entity\Criteria cr '
            . 'WHERE cr.id = ch.fkCriteria '
            . 'AND cr.id = :id '
            . 'AND cr.isApplicable = :isApplicable'
        )
            ->setParameters(['isApplicable' => $isApplicable, 'id' => $id]);
        return $query->getResult();
    }
}
