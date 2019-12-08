<?php

namespace App\Repository;

use App\Entity\Competence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Competence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competence[]    findAll()
 * @method Competence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Competence::class);
        $this->entityManager = $this->getEntityManager();
    }


    public function fetchApplicable(int $isApplicable = 1)
    {
        $query = $this->entityManager->createQuery('SELECT comp.title AS competence, cr.id, cr.title AS criteria '
            . 'FROM App\Entity\Competence comp JOIN App\Entity\Criteria cr '
            . 'WHERE comp.id=cr.fkCompetence '
            . 'AND comp.isApplicable = :isApplicable')
            ->setParameter('isApplicable', $isApplicable);
        return $query->getResult();
    }

    public function fetchApplicableByCompetence(string $title, int $isApplicable = 1)
    {
        $query = $this->entityManager->createQuery('SELECT cr.id, cr.title AS criteria '
            . 'FROM App\Entity\Competence comp JOIN App\Entity\Criteria cr '
            . 'WHERE comp.id=cr.fkCompetence '
            . 'AND comp.isApplicable = :isApplicable AND comp.title = :title')
            ->setParameters(['isApplicable' => $isApplicable, 'title' => $title]);
        return $query->getResult();
    }
}
