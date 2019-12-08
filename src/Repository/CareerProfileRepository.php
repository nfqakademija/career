<?php

namespace App\Repository;

use App\Entity\CareerProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CareerProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerProfile[]    findAll()
 * @method CareerProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerProfileRepository extends ServiceEntityRepository
{
    /** @var EntityManager  */
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CareerProfile::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(CareerProfile $careerProfile)
    {
        $this->entityManager->persist($careerProfile);
        $this->entityManager->flush();
    }

    public function fetchProfileByProfession(int $id, int $isArchived = 0)
    {
        $query = $this->entityManager->createQuery('SELECT pr.title AS position, ca.id '
            . 'FROM App\Entity\Profession pr JOIN App\Entity\CareerProfile ca '
            . 'WHERE ca.profession=pr.id '
            . 'AND ca.isArchived = :isArchived '
            . 'AND pr.id=:id')
            ->setParameters(['isArchived' => $isArchived, 'id' => $id]);

        return $query->getResult();
    }
}
