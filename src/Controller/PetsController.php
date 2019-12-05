<?php

namespace App\Controller;

use App\Entity\Secondary\Billing;
use App\Entity\Secondary\Pet;
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

    




    


}