<?php

namespace App\Repository;

use App\Entity\Secondary\Billing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Billing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billing[]    findAll()
 * @method Billing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billing::class);
    }

    public function getSumUsersSub() {
        return $this->createQueryBuilder('b')
            ->select('SUM(b.amount)')
            ->getQuery()
            ->getResult();
    }

    public function getSubByActiveUser() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = 'SELECT COUNT(*) as abonnements FROM billing INNER JOIN user on billing.user_iduser = user.iduser WHERE dateBilling <= CURRENT_DATE AND user.active = 1';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAmountMonthYear() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
        SELECT SUM(amount) as Montants
        FROM billing
        WHERE MONTH(dateBilling) = \'11\'
        UNION
        SELECT SUM(amount)
        FROM billing
        WHERE YEAR(dateBilling) = \'2019\'
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
