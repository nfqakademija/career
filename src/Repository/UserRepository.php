<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findTeamManager($teamId, $role = "ROLE_HEAD", $isActive = 1)
    {

        $query = $this->entityManager->createQuery(
            'SELECT u '
            . 'FROM App\Entity\User u '
            . 'JOIN u.team t '
            . 'WHERE u.roles LIKE :role '
            . 'AND t.id = :teamId '
            . 'AND u.isActive = :isActive'
        )
            ->setParameters(['teamId' => $teamId, 'role' => '%"' . $role . '"%', 'isActive' => $isActive]);
        return $query->getResult();
    }

    public function findTeamUsers($teamId, $isActive = 1)
    {

        $query = $this->entityManager->createQuery(
            'SELECT u '
            . 'FROM App\Entity\User u '
            . 'JOIN u.team t '
            . 'WHERE t.id = :teamId '
            . 'AND u.isActive = :isActive'
        )
            ->setParameters(['teamId' => $teamId, 'isActive' => $isActive]);
        return $query->getResult();
    }
}
