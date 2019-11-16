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

    public function fetchByCompetence(string $title)
    {
        $query = $this->entityManager->createQuery(
            'SELECT c.id, c.title AS Criteria, p.title AS Competence '
            . 'FROM App\Entity\Criteria c '
            . 'INNER JOIN App\Entity\Competence p '
            . 'WHERE p.id = c.fkCompetence '
            . 'AND p.title = :title')->setParameter('title', $title);
        return $query->getResult();
    }

    public function fetchByCompetenceWithChoices(string $title)
    {
        $query = $this->entityManager->createQuery(
            'SELECT c.title AS Criteria, p.title AS Competence, h.title AS Choice '
            . 'FROM App\Entity\Criteria c '
            . 'JOIN App\Entity\CriteriaChoice h '
            . 'INNER JOIN App\Entity\Competence p '
            . 'WHERE  c.id = h.fkCriteria '
            . 'AND p.id = c.fkCompetence '
            . 'AND p.title = :title '
            . 'AND c.isApplicable = 1')->setParameter('title', $title);
        return $query->getResult();
    }
}
