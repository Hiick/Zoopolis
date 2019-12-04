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
        return $this->render('Dashboard/base.html.twig');
    }

    public function getSumUsersSub(EntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(Billing::class)->getSumUsersSub();
        return $this->responseApi([
            $listUsers[0][1],
        ]);
    }

}