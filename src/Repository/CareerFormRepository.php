<?php

namespace App\Repository;

use App\Entity\CareerForm;
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

    /**
     * Creates new table with a passed title.
     * !!! JUST FOR TESTING
     * !!! This logic should be cut out to a separate service as it is not a publicly accessible rest service
     * @param string $title
     * @throws \Doctrine\DBAL\DBALException
     */
    public function newTable(string $title)
    {

        $sql = 'CREATE TABLE IF NOT EXISTS ' . $title . '
(id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB';

        $statement = $this->entityManager->getConnection()->prepare($sql);
        $statement->execute();
        return ($statement->errorCode() === '0000')? true : false;

    }


}
