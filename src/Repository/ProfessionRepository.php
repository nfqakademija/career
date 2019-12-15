<?php

namespace App\Repository;

use App\Entity\Profession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Profession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profession[]    findAll()
 * @method Profession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    /**
     * ProfessionRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Profession::class);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @return mixed
     */
    public function fetchTitlesAndIds()
    {
        $query = $this->entityManager->createQuery('SELECT p.id, p.title '
            . 'FROM App\Entity\Profession p');

        return $query->getResult();
    }
}
