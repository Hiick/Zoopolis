<?php

namespace App\Controller;

use App\Entity\Main\Admin;
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

}