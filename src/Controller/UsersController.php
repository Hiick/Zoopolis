<?php

namespace App\Controller;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends BaseController {

    /**
     * @Route("/admin/users", name="users")
     */
    public function start(): Response {
        return $this->render('Dashboard/Users/base.html.twig');
    }

}