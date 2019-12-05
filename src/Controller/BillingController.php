<?php

namespace App\Controller;

use App\Entity\Secondary\Billing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillingController extends BaseController {

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function start(): Response {
        return $this->render('Dashboard/Billings/base.html.twig');
    }

    public function getSumUsersSub(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listSubs = $entityManager->getRepository(Billing::class)->getSumUsersSub();
        return $this->responseApi([
            $listSubs[0][1],
        ]);
    }

    public function getSubByActiveUser(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listSubs = $entityManager->getRepository(Billing::class)->getSubByActiveUser();
        return $this->responseApi([
            $listSubs[0]['abonnements'],
        ]);
    }

    public function getAmountMonthYear(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listSubs = $entityManager->getRepository(Billing::class)->getAmountMonthYear();
        return $this->responseApi([
            "Montants" => $listSubs
        ]);
    }

}