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

    public function fetchByCompetenceTitle(string $title)
    {

        $query = $this->entityManager->createQuery(
            'SELECT c.id, c.title AS Criteria, p.title AS Competence '
            . 'FROM App\Entity\Criteria c '
            . 'INNER JOIN App\Entity\Competence p '
            . 'WHERE p.id = c.fk_competence '
            . 'AND p.title = :title')->setParameter('title', $title);
        return $query->getResult();
    }

}
