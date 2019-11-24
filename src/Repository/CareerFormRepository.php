<?php

namespace App\Repository;

use App\Entity\CareerForm;
use App\Entity\CareerProfile;
use App\Entity\Criteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CareerForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerForm[]    findAll()
 * @method CareerForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerFormRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CareerForm::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(CareerForm $careerForm)
    {
        $this->entityManager->persist($careerForm);
        $this->entityManager->flush();
    }

}
