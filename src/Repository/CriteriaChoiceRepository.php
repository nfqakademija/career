<?php

namespace App\Repository;

use App\Entity\CriteriaChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CriteriaChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CriteriaChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CriteriaChoice[]    findAll()
 * @method CriteriaChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriteriaChoiceRepository extends ServiceEntityRepository
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CriteriaChoice::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function create(CriteriaChoice $criteriaChoice)
    {
        $this->entityManager->persist($criteriaChoice);
    }

    public function save()
    {
        $this->entityManager->flush();
    }

}
