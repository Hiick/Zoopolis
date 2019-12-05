<?php

namespace App\Repository;

use App\Entity\Secondary\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

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

    public function getByAges() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();

    $sql = '
        SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) > (18*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) >= (18*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (25*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) >= (26*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (35*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) >= (36*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (50*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) > (50*365.25)
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();

    }

    public function getByEmail() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
        select
        substring(email,LOCATE("@",email)+1,LENGTH(email)) as domaine,
        count(*) as nb_domaine
        from user
        where createdat <NOW()
        group by domaine
        order by nb_domaine DESC
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function listUsers($start, $end) {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
        SELECT *
        FROM user
        ORDER BY iduser ASC
        LIMIT '.$start.', '.$end;

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countListUsers($nb = 10) {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = 'SELECT ROUND(COUNT(*)/'.$nb.') as pagination FROM user';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteUser($id) {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = 'DELETE FROM `user`
        WHERE id='. $id .' ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getId() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = 'SELECT iduser from user';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function subByDayWeekMonth() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
        SELECT COUNT(*) as Inscrits
        FROM user 
        WHERE createdAt > CURRENT_DATE AND createdAt < CURRENT_DATE + INTERVAL 1 DAY
        UNION
        SELECT COUNT(*) 
        FROM user 
        WHERE createdAt > CURRENT_DATE AND createdAt < CURRENT_DATE + INTERVAL 7 DAY
        UNION
        SELECT COUNT(*)  
        FROM user 
        WHERE createdAt > CURRENT_DATE AND createdAt < CURRENT_DATE + INTERVAL 1 MONTH
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
