<?php

namespace App\Controller;

use App\Entity\Secondary\Billing;
use App\Entity\Secondary\Pet;
use App\Entity\Secondary\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PetsController extends BaseController {

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function start(): Response {
        return $this->render('Dashboard/Pets/base.html.twig');
    }

    public function addPetForm(): Response {
        return $this->render('Dashboard/Add-pets/base.html.twig');
    }

    public function listPets(EntityManagerInterface $entityManager, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');

        $content = $request->getContent();

        $params = json_decode($content, true);
        $record_per_page = 10;
        $page=$params["page"];
        $start_from = ($page - 1)*$record_per_page;
        $listUsers = $entityManager->getRepository(Pet::class)->listPets($start_from, $record_per_page);

        return $this->responseApi($listUsers);

    }

    public function countListPets(EntityManagerInterface $entityManager, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Pet::class)->countListPets();
        return $this->responseApi($listUsers);
    }

    public function getMensPet(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Pet::class)->getBySexePet('Homme');
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }

    public function getWomensPet(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Pet::class)->getBySexePet('Femme');
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }
    public function getAllPets(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Pet::class)->getAllPets();
        return $this->responseApi([
            $listUsers[0][1],
        ]);

    }

    public function getPetPerCountry(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Pet::class)->getPetPerCountry();

        $list_final = [];

        for ($i = 0; $i < count($listUsers); $i++) {
            array_push($list_final, $listUsers[$i]["COUNT(*)"]);
        }

        return $this->responseApi($list_final);
    }

    public function getByTypes(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listPets = $entityManager->getRepository(Pet::class)->getByTypes();

        $list_final = [];

        for ($i = 0; $i < count($listPets); $i++) {
            array_push($list_final, $listPets[$i]["Types"]);
        }

        return $this->responseApi($list_final);
    }

    public function getByRaces(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Pet::class)->getByRaces();

        $list_final = [];

        for ($i = 0; $i < count($listUsers); $i++) {
            array_push($list_final, $listUsers[$i]["Races"]);
        }

        return $this->responseApi($list_final);
    }

    public function newPet(EntityManagerInterface $entityManager, Request $request): Response {
        $content = $request->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true);

            $user = new Pet();
            $user->setName($params['name']);
            $user->setType($params['type']);
            $user->setRace($params['race']);
            $user->setBirthday($params['birthday']);
            $user->setSexe($params['sexe']);
            $user->setDateacquisition($params['dateacquisition']);
            $user->setUserIduser($params['useriduser']);
            $user->setCreatedat(new \DateTime());
            $user->setUpdatedat(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager('customer');
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->responseApi([
            "data" => json_decode($content, true)
        ], 200);
    }
}