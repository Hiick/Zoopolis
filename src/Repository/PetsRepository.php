<?php

namespace App\Repository;

use App\Entity\Secondary\Pet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pet[]    findAll()
 * @method Pet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pet::class);
    }

    public function countListPets($nb = 10) {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = 'SELECT ROUND(COUNT(*)/'.$nb.') as pagination FROM pet';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listPets($start, $end) {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
            SELECT *
            FROM pet
            ORDER BY pet.idpet ASC
            LIMIT '.$start.', '.$end;

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getBySexePet($sexe)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where("p.sexe = :sexe")
            ->setParameter('sexe', $sexe)
            ->getQuery()
            ->getResult();
    }

    public function getAllPets()
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getResult();
    }

    public function getPetPerCountry() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
        SELECT COUNT(*), user.city
        FROM pet
        INNER JOIN user ON iduser = user_iduser 
        GROUP BY user.city
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function newPet($name, $type, $race, $birthday, $sexe, $dateAcquisition, $user_iduser) {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
        INSERT INTO pet 
        (pet.name, pet.type, pet.race, pet.birthday, pet.sexe, pet.dateAcquisition, pet.user_iduser) 
        VALUES ('.$name.','.$type.', '.$race.','.$birthday.','.$sexe.','.$dateAcquisition.','.$user_iduser.')
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByTypes() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
            SELECT COUNT(*) as Types
            FROM pet
            GROUP BY pet.type
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function getByRaces() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();

        $sql = '
            SELECT COUNT(*) as Races
            FROM pet
            GROUP BY pet.race
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
}
