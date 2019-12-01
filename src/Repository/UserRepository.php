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

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

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
