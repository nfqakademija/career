<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findTeamManager($teamId, $role = "ROLE_HEAD")
    {

        $query = $this->entityManager->createQuery(
            'SELECT u'
            . 'FROM App\Entity\User u '
            . 'JOIN App\Entity\Team t '
            . 'WHERE u.roles LIKE :role '
            . 'AND t.id = :teamId '
        )
            ->setParameters(['teamId' => $teamId, 'role' => '%"'.$role.'"%']);
        return $query->getResult();
    }

    public function findTeamUsers($teamId)
    {

        $query = $this->entityManager->createQuery(
            'SELECT u'
            . 'FROM App\Entity\User u '
            . 'JOIN App\Entity\Team t '
            . 'WHERE t.id = :teamId '
        )
            ->setParameters(['teamId' => $teamId]);
        return $query->getResult();
    }
}
