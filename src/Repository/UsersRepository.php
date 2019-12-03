<?php

namespace App\Repository;

use App\Entity\Secondary\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getBySexe($sexe)
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where("u.sexe = :sexe")
            ->setParameter('sexe', $sexe)
            ->getQuery()
            ->getResult();
    }

    public function getAllUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->getQuery()
            ->getResult();
    }

    public function getAllActiveUsers()
    {
        $datetime = new \DateTime("now");

        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.active = 1')
            ->andWhere('u.createdat <= :now')
            ->setParameter('now', $datetime->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }
}
