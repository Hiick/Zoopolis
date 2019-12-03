<?php

namespace App\Controller;

//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;

use App\Entity\Main\Admin;
use Couchbase\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends BaseController {

    public function start(): Response {
        return $this->render('LoginPage/base.html.twig');
    }

    /**
     * @return RedirectResponse
     * @Route("/connexion", name="security_login")
     */
    public function login() {
        return $this->redirect('/admin/dashboard');
    }

}