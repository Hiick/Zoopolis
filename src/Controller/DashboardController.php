<?php

namespace App\Controller;

use App\Entity\Main\Admin;
use App\Entity\Secondary\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseController {

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function start(): Response {
        return $this->render('Dashboard/base.html.twig');
    }

    public function getByEmail(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getByEmail();
        $listDomain = [];
        $listDatas = [];
        for ($i = 0; $i < count($listUsers); $i ++) {
            array_push($listDomain, $listUsers[$i]["domaine"]);
            array_push($listDatas, $listUsers[$i]["nb_domaine"]);
        }
        return $this->responseApi([
            "Labels" => $listDomain,
            "Datas" => $listDatas
        ]);
    }

}